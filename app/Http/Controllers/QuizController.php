<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $code = $this->generateUniqueRoomCode();
        $status = $request->status;
        $quizList = $request->quizList;
        $quizTitle = $request->quizTitle;
        $quizDescription = $request->quizDescription;
        $userLimit = $request->userLimit;

        $isQuizSaved = false;
        $isQuestionsSaved = false;
        $quizId = null;

        try {
            
            $quiz = Quiz::create([
                'user_id' => $userId,
                'code' => $code,
                'title' => $quizTitle,
                'description' => $quizDescription,
                'status' => $status,
                'user_limit' => $userLimit,
            ]);

            $quizId = $quiz->id;

            $isQuizSaved = true;

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save quiz. ',
                'error' => $e->getMessage()
            ]);
        }

        if ($isQuizSaved) {
            try {
                foreach ($quizList as $quiz){
                    $choiceA = $quiz['choices']['A'];
                    $choiceB = $quiz['choices']['B'];
                    $choiceC = $quiz['choices']['C'];
                    $choiceD = $quiz['choices']['D'];

                    Question::create([
                        'quiz_id' => $quizId,
                        'question' => $quiz['question'],
                        'choice_a' => $choiceA,
                        'choice_b' =>  $choiceB,
                        'choice_c' =>  $choiceC,
                        'choice_d' => $choiceD,
                        'answer_key' => $quiz['answerKey'],
                        'time_limit' => $quiz['timeLimit'],
                        'points' => $quiz['points'],
                    ]);
                }

                $isQuizSaved = true;

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save question. ',
                    'error' => $e->getMessage(),
                    'quizList' => $quizList,
                    // 'choices' => $temp,
                ]); 
            }
        }

        return response([
            'success' => true,
            'status' => $status,
            'code' => $code,
            'userId' => $userId,
            'quizList' => $quizList,
            'quizTitle' => $quizTitle,
            'quizDescription' => $quizDescription,
            'userLimit', $userLimit,
        ]);
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
        //
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
}
