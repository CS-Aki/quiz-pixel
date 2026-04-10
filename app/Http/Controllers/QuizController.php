<?php

namespace App\Http\Controllers;

use App\Events\QuizLeaderboardUpdated;
use App\Events\QuizStarted;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create-quiz');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'quiz_id' => 'required|integer',
            'quiz_code' => 'required|string',
            'score' => 'required|integer|min:0',
            'correct_count' => 'required|integer|min:0',
            'total_questions' => 'required|integer|min:1',
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
                'score' => $validated['score'],
                'correct_count' => $validated['correct_count'],
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
                    'rank' => $index + 1,
                    'user_id' => $row->user_id,
                    'name' => $row->user?->username ?? 'Unknown Player',
                    'score' => $row->score,
                    'correct_count' => $row->correct_count,
                    'total_questions' => $row->total_questions,
                ];
            })
            ->toArray();

        broadcast(new QuizLeaderboardUpdated($quiz->id, $leaderboard))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Quiz submitted successfully.',
            'result' => [
                'id' => $result->id,
                'score' => $result->score,
                'correct_count' => $result->correct_count,
                'total_questions' => $result->total_questions,
            ],
            'leaderboard' => $leaderboard,
        ]);
    }

    public function start(Request $request, $quizCode)
    {
        // Optional host guard
        abort_if(Auth::id() !== Quiz::where('code', $quizCode)->value('user_id'), 403);

        broadcast(new QuizStarted($quizCode)); // ← no ->toOthers()

        return response()->json(['status' => 'started']);
    }

    public function quizHistory()
    {
        $userId = Auth::user()->id;
        $results = QuizResult::where('user_id' , $userId)->get();

        $quizzesTaken = $results->count();
        $avgScore = $results->where('total_questions', '>', 0)
                    ->avg(fn($r) => ($r->correct_count / $r->total_questions) * 100);
        $avgScore = $avgScore ? round($avgScore) : 0;

        $bestScore = QuizResult::where('quiz_id', $results[0]->quiz_id)
            ->orderByDesc('score')->firstOrFail();
        
        $bestScore = $bestScore->score;
        $lowestScore = QuizResult::where('quiz_id', $results[0]->quiz_id)
            ->orderBy('score', 'asc')->firstOrFail();
        $lowestScore = $lowestScore->score;

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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quiz = Quiz::find($id);
        $questions = $quiz->questions;

        return view("edit-quiz", compact("quiz", "questions"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
