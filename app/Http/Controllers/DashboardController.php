<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = FacadesAuth::user()->id;
        $now = now();
        $startOfWeek = $now->startOfWeek();

        $quizzes = Quiz::where('user_id', $userId)->get();
        $results = QuizResult::where('user_id', $userId)->get();

        // Quizzes Taken
        $quizzesTaken = $results->count();
        $quizzesTakenThisWeek = QuizResult::where('user_id', $userId)
            ->where('created_at', '>=', $startOfWeek)
            ->count();

        // Quizzes Created
        $quizzesCreated = $quizzes->count();
        $quizzesCreatedThisWeek = Quiz::where('user_id', $userId)
            ->where('created_at', '>=', $startOfWeek)
            ->count();

        // Avg. Score (based on correct_count / total_questions * 100)
        $avgScore = $results->where('total_questions', '>', 0)
            ->avg(fn($r) => ($r->correct_count / $r->total_questions) * 100);
        $avgScore = $avgScore ? round($avgScore) : 0;

        // Avg. Score last week (for comparison)
        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();
        $lastWeekResults = QuizResult::where('user_id', $userId)
            ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->get();
        $avgScoreLastWeek = $lastWeekResults->where('total_questions', '>', 0)
            ->avg(fn($r) => ($r->correct_count / $r->total_questions) * 100);
        $avgScoreLastWeek = $avgScoreLastWeek ? round($avgScoreLastWeek) : 0;
        $avgScoreDiff = $avgScore - $avgScoreLastWeek;

        // Best Rank — rank user by total score across all users per quiz
        // Get the user's highest rank position among all participants
        $bestRank = null;
        $userQuizIds = $results->pluck('quiz_id')->unique();
        foreach ($userQuizIds as $quizId) {
            $allScores = QuizResult::where('quiz_id', $quizId)
                ->orderByDesc('score')
                ->pluck('user_id')
                ->values();
            $rank = $allScores->search($userId);
            if ($rank !== false) {
                $rank += 1; // Convert to 1-based
                if ($bestRank === null || $rank < $bestRank) {
                    $bestRank = $rank;
                }
            }
        }

        return view('user-dashboard', compact(
            'quizzes', 'results',
            'quizzesTaken', 'quizzesTakenThisWeek',
            'quizzesCreated', 'quizzesCreatedThisWeek',
            'avgScore', 'avgScoreDiff',
            'bestRank'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
