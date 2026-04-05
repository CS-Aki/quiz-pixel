<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Redirect user to Google's OAuth page
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle the callback from Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'first_name' => $googleUser->user['given_name'],
                    'last_name'  => $googleUser->user['family_name'],
                    'username'   => $googleUser->getNickname() ?? str()->slug($googleUser->getName()) . '_' . rand(100, 999),
                    'email'      => $googleUser->getEmail(),
                    'avatar'     => $googleUser->getAvatar(),
                    'google_id'  => $googleUser->getId(),
                    'password'   => null,
                ]
            );

            Auth::login($user, remember: true);

            return redirect()->intended('/user-dashboard');

        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
    }
}