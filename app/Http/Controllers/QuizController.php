<?php

namespace App\Http\Controllers;

use App\Events\QuizLeaderboardUpdated;
use App\Events\QuizResultSubmitted;
use App\Events\QuizStarted;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class QuizController extends Controller
{

    public function index()
    {
       
    }

    public function create()
    {
        return view('create-quiz');
    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $status = $request->status;
        $quizList = $request->quizList;
        $quizTitle = $request->quizTitle;
        $quizDescription = $request->quizDescription;
        $userLimit = $request->userLimit;
        $quizId = $request->quizId;

        try {
            $quiz = Quiz::updateOrCreate(
                [
                    'id' => $quizId,
                ],
                [
                    'user_id' => $userId,
                    'code' => $request->quizId != 0 ? $request->quizCode : $this->generateUniqueRoomCode(),
                    'title' => $quizTitle,
                    'description' => $quizDescription,
                    'status' => $status,
                    'user_limit' => $userLimit,
                ]
            );

            $quizId = $quiz->id;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save quiz.',
                'error' => $e->getMessage()
            ]);
        }

        $savedQuestions = [];

        try {
            foreach ($quizList as $questionData) {
                $data = [
                    'quiz_id' => $quizId,
                    'question' => $questionData['question'],
                    'choice_a' => $questionData['choices']['A'],
                    'choice_b' => $questionData['choices']['B'],
                    'choice_c' => $questionData['choices']['C'],
                    'choice_d' => $questionData['choices']['D'],
                    'answer_key' => $questionData['answerKey'],
                    'time_limit' => $questionData['timeLimit'],
                    'points' => $questionData['points'],
                ];

                if (!empty($questionData['id']) && $questionData['id'] > 0) {
                    $question = Question::where('id', $questionData['id'])
                        ->where('quiz_id', $quizId)
                        ->first();

                    if ($question) {
                        $question->update($data);
                    } else {
                        $question = Question::create($data);
                    }
                } else {
                    $question = Question::create($data);
                }

                $savedQuestions[] = [
                    'questionNum' => $questionData['questionNum'],
                    'id' => $question->id,
                ];
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save question.',
                'error' => $e->getMessage(),
                'quizList' => $quizList,
            ]);
        }

        return response()->json([
            'success' => true,
            'id' => $quizId,
            'code' => $quiz->code,
            'status' => $status,
            'questions' => $savedQuestions,
        ]);
    }

    public function quizList(){
        $userId = Auth::user()->id;
        $quizzes = Quiz::where('user_id', $userId)->get();
        $results = QuizResult::where('user_id' , $userId)->get();

        $avgScore = $results->where('total_questions', '>', 0)
                    ->avg(fn($r) => ($r->correct_count / $r->total_questions) * 100);
        $avgScore = $avgScore ? round($avgScore) : 0;

        return view('quiz-list', compact('quizzes', 'avgScore'));
    }

    public function deleteQuestion(string $id){
        $question = Question::find($id);
        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question deleted successfully.',
        ]);
    }

    public function deleteQuiz(string $id){
        // $quiz = Quiz::find($id);
        // $quiz->delete();
        $quiz = Quiz::where('id', $id)->update(['status' => 'archived']);

        return response()->json([
            'success' => true,
            'message' => 'Quiz closed successfully.',
        ]);
    }

    public function publishQuiz(Request $request){
        $quiz = Quiz::find($request->quizId);
        $quiz->status = "published";
        $quiz->save();
    }

    public function toQuizAnswer(Request $request){
        $code = $request->quizCode;
        $quiz = Quiz::where('code', $code)->firstOrFail();
        $questions = $quiz->questions;
        $user = Auth::user();

        $formattedQuestions = $quiz->questions->map(function ($q) {
            return [
                'id'       => $q->id,
                'text'     => $q->question, // <-- fix field name
                'choices'  => [
                    ['label' => 'A', 'text' => $q->choice_a],
                    ['label' => 'B', 'text' => $q->choice_b],
                    ['label' => 'C', 'text' => $q->choice_c],
                    ['label' => 'D', 'text' => $q->choice_d],
                ],
                'correct'  => $q->answer_key, // <-- fix field name
                'time'     => $q->time_limit ?? 30,
                'points'   => $q->points ?? 1,
            ];
        });

        $questionsJson = $formattedQuestions;

        $leaderboard = QuizResult::with('user')
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('score')
            ->orderByDesc('correct_count')
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->values()
            ->map(function ($row, $index) {
                return [
                    'rank' => $index + 1,
                    'user_id' => $row->user_id,
                    'name' => $row->user?->username ?? 'Unknown Player',
                    'score' => $row->score,
                    'correct_count' => $row->correct_count,
                    'total_questions' => $row->total_questions,
                ];
            });

        return view('answer-quiz', compact('quiz', 'questions', 'user', 'questionsJson', 'leaderboard'));
    }

    public function submitQuiz(Request $request, $quizId)
    {
        $validated = $request->validate([
            'quiz_id'        => 'required|integer',
            'quiz_code'      => 'required|string',
            'score'          => 'required|numeric|min:0',  // numeric not integer
            'correct_count'  => 'required|integer|min:0',
            'total_questions'=> 'required|integer|min:1',
        ]);
    
        $quiz = Quiz::where('id', $quizId)
            ->where('code', $validated['quiz_code'])
            ->firstOrFail();

        $user = Auth::user();

        $result = QuizResult::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'user_id' => $user->id,
            ],
            [
                'score'           => (int) round($validated['score']),  // store as rounded int
                'correct_count'   => $validated['correct_count'],
                'total_questions' => $validated['total_questions'],
            ]
        );

        $leaderboard = QuizResult::with('user')
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('score')
            ->orderByDesc('correct_count')
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->values()
            ->map(function ($row, $index) {
                return [
                    'rank'            => $index + 1,
                    'user_id'         => $row->user_id,
                    'name'            => $row->user?->first_name . ' ' . $row->user?->last_name ?? 'Unknown Player',
                    'score'           => $row->score,
                    'correct_count'   => $row->correct_count,
                    'total_questions' => $row->total_questions,
                ];
            })
            ->toArray();

        $result->load('user');  // needed so broadcastWith() can access ->user

        broadcast(new QuizLeaderboardUpdated($quiz->id, $leaderboard))->toOthers();
        broadcast(new QuizResultSubmitted($quiz->code, $result));  // remove toOthers() so host receives it

        return response()->json([
            'success'    => true,
            'message'    => 'Quiz submitted successfully.',
            'result'     => [
                'id'              => $result->id,
                'score'           => $result->score,
                'correct_count'   => $result->correct_count,
                'total_questions' => $result->total_questions,
            ],
            'leaderboard' => $leaderboard,
        ]);
    }

    public function start(Request $request, $quizCode)
    {
        $quiz = Quiz::where('code', $quizCode)->firstOrFail();

        abort_if(Auth::id() !== $quiz->user_id, 403);

        broadcast(new QuizStarted($quizCode));

        return response()->json([
            'status'  => 'started',
            'quiz_id' => $quiz->id,
        ]);
    }

    public function quizHistory()
    {
        $userId = Auth::user()->id;
        $results = QuizResult::where('user_id' , $userId)->get();

        $quizzesTaken = $results->count();
        $avgScore = $results->where('total_questions', '>', 0)
                    ->avg(fn($r) => ($r->correct_count / $r->total_questions) * 100);
        $avgScore = $avgScore ? round($avgScore) : 0;

        if ($results->isNotEmpty()) {
            $quizId = $results->first()->quiz_id;

            $bestScoreRecord = QuizResult::where('quiz_id', $quizId)
                ->orderByDesc('score')
                ->first();

            $lowestScoreRecord = QuizResult::where('quiz_id', $quizId)
                ->orderBy('score', 'asc')
                ->first();

            $bestScore = $bestScoreRecord ? $bestScoreRecord->score : null;
            $lowestScore = $lowestScoreRecord ? $lowestScoreRecord->score : null;
        } else {
            $bestScore = null;
            $lowestScore = null;
        }

        $userRanking = array();
        
        $i = 0;

        foreach ($results as $result) {
            $ranks = QuizResult::where('quiz_id', $result->quiz_id)->orderBy('score', 'desc')->get();

            foreach ($ranks as $rank) {
                $i+=1;
                if ($rank->user_id == $userId) {
                    $userRanking[$result->quiz_id] = $i;
                    $i = 0;
                } 
            }
        }

        // $quizzes = $history->quiz;
        return view('quiz-history', compact('results', 'userRanking', 'quizzesTaken', 'avgScore', 'bestScore', 'lowestScore'));
    }

    public function quizResults(string $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
    
        abort_if(Auth::id() !== $quiz->user_id, 403);
    
        $results = QuizResult::with('user')
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('score')
            ->orderByDesc('correct_count')
            ->get();
    
        $totalPlayers = $results->count();
    
        $avgScore = $totalPlayers > 0
            ? round($results->avg(fn($r) => $r->total_questions > 0
                ? ($r->correct_count / $r->total_questions) * 100
                : 0))
            : 0;
    
        $highestScore = $results->max('score') ?? 0;
    
        $completionRate = $totalPlayers > 0
            ? round(
                $results->filter(fn($r) => $r->total_questions > 0
                    && $r->correct_count + ($r->total_questions - $r->correct_count) === $r->total_questions
                )->count() / $totalPlayers * 100
            )
            : 0;
    
        $completionRate = $totalPlayers > 0
            ? round($results->where('total_questions', '>', 0)->count() / $totalPlayers * 100)
            : 0;
    
        $scoreBand90      = 0;
        $scoreBand70      = 0;
        $scoreBand50      = 0;
        $scoreBandBelow50 = 0;
    
        foreach ($results as $r) {
            if ($r->total_questions <= 0) continue;
            $pct = ($r->correct_count / $r->total_questions) * 100;
    
            if ($pct >= 90)      $scoreBand90++;
            elseif ($pct >= 70)  $scoreBand70++;
            elseif ($pct >= 50)  $scoreBand50++;
            else                 $scoreBandBelow50++;
        }
    
        $leaderboard = $results->values()->map(function ($row, $index) {
            $row->rank        = $index + 1;
            $row->player_name = $row->user?->first_name . " " . $row->user?->last_name ?? 'Unknown Player';
            return $row;
        });
    
    
        $questions     = $quiz->questions;
        $questionStats = [];
    
        foreach ($questions as $idx => $question) {

            $totalCount   = $totalPlayers;
            $correctCount = $totalPlayers > 0
                ? round($results->avg(fn($r) => $r->total_questions > 0
                    ? ($r->correct_count / $r->total_questions)
                    : 0) * $totalPlayers)
                : 0;
    
            $accuracy = $totalCount > 0 ? round(($correctCount / $totalCount) * 100) : 0;
    
            // Build human-readable correct answer label
            $answerKey     = strtoupper($question->answer_key);
            $choiceField   = 'choice_' . strtolower($answerKey);
            $correctAnswer = $answerKey . '. ' . ($question->{$choiceField} ?? '—');
    
            $questionStats[] = [
                'question'       => $question->question,
                'correct_answer' => $correctAnswer,
                'correct_count'  => $correctCount,
                'total'          => $totalCount,
                'accuracy'       => $accuracy,
            ];
        }
    
        return view('quiz-result', compact(
            'quiz',
            'leaderboard',
            'totalPlayers',
            'avgScore',
            'highestScore',
            'completionRate',
            'scoreBand90',
            'scoreBand70',
            'scoreBand50',
            'scoreBandBelow50',
            'questionStats',
        ));
    }

    public function exportQuizResults(string $id): StreamedResponse
    {
        $quiz = Quiz::findOrFail($id);
        abort_if(Auth::id() !== $quiz->user_id, 403);
    
        $results = QuizResult::with('user')
            ->where('quiz_id', $quiz->id)
            ->orderByDesc('score')
            ->get();
    
        $filename = 'quiz-results-' . str_replace(' ', '-', strtolower($quiz->title)) . '-' . now()->format('Ymd') . '.csv';
    
        return response()->streamDownload(function () use ($results, $quiz) {
    
            $handle = fopen('php://output', 'w');
    
            // Header row
            fputcsv($handle, [
                'Rank',
                'Player',
                'Score (pts)',
                'Correct Answers',
                'Total Questions',
                'Accuracy (%)',
                'Submitted At',
            ]);
    
            foreach ($results->values() as $index => $row) {
                $accuracy = $row->total_questions > 0
                    ? round(($row->correct_count / $row->total_questions) * 100)
                    : 0;
    
                fputcsv($handle, [
                    $index + 1,
                    $row->user?->first_name . " " . $row->user?->last_name?? 'Unknown Player',
                    $row->score,
                    $row->correct_count,
                    $row->total_questions,
                    $accuracy . '%',
                    $row->created_at->format('Y-m-d H:i:s'),
                ]);
            }
    
            fclose($handle);
    
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function edit(string $id)
    {
        $quiz = Quiz::find($id);
        $questions = $quiz->questions;

        return view("edit-quiz", compact("quiz", "questions"));
    }
    
    function generateRoomCode()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';

        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $code;
    }

    function generateUniqueRoomCode()
    {
        do {
            $code = $this->generateRoomCode();
        } while (Quiz::where('code', $code)->exists());

        return $code;
    }

}
