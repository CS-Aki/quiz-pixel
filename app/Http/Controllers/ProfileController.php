<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = Auth::user();

        $user->update([             
            'password' => bcrypt($request->password),
        ]);

        return back()->with('success', 'Password set successfully!');
    }
}
