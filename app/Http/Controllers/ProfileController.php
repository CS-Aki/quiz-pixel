<?php

namespace App\Http\Controllers;

use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    
    public function index()
    {
        $user   = Auth::user();
        $userId = $user->id;

        $results = QuizResult::where('user_id', $userId)->with('quiz')->get();

        $quizzesTaken   = $results->count();
        $quizzesCreated = $user->quizzes()->count();

        $avgScore = $results->where('total_questions', '>', 0)
            ->avg(fn($r) => ($r->correct_count / $r->total_questions) * 100);
        $avgScore = $avgScore ? round($avgScore) : 0;

        // Best rank across all quizzes
        $bestRank = null;
        $i = 0;

        foreach ($results as $result) {
            $ranks = QuizResult::where('quiz_id', $result->quiz_id)
                ->orderByDesc('score')
                ->get();

            foreach ($ranks as $rank) {
                $i++;
                if ($rank->user_id === $userId) {
                    if ($bestRank === null || $i < $bestRank) {
                        $bestRank = $i;
                    }
                    $i = 0;
                    break;
                }
            }
        }

        return view('profile', compact('quizzesTaken', 'quizzesCreated', 'avgScore', 'bestRank'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data = $request->only('first_name', 'last_name', 'email');

        if ($request->hasFile('avatar')) {
            // Delete old avatar if stored locally
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = Storage::url($path);
        }

        $user->update($data);

        return response()->json(['message' => 'Profile updated successfully.']);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'new_password' => ['required', 'min:8', 'confirmed'],
        ];

        // Only require current password if user already has one
        if ($user->password) {
            $rules['current_password'] = ['required'];
        }

        $request->validate($rules);

        if ($user->password && !Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'errors' => ['current_password' => ['Current password is incorrect.']]
            ], 422);
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Delete avatar from storage if local
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Account deleted successfully.']);
    }
}