<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/', function () {
    return view('landing-page');
});

Route::post('/set-password', [ProfileController::class, 'setPassword'])->name('profile.set-password');

Route::get('/login', [LoginController::class, 'index'])->name("to-login");
Route::post('/login-user', [LoginController::class, 'login'])->name("login");
Route::post('/logout-user', [LoginController::class, 'logout'])->name("logout");

Route::get('/register', [RegisterController::class, 'index'])->name("to-register");
Route::post('/register-user', [RegisterController::class, 'register'])->name("register");

Route::get('/user-dashboard', [DashboardController::class, 'index'])->name('to-dashboard');

Route::get('/to-create-quiz', [QuizController::class, 'create'])->name('to-create-quiz');
Route::post('/save-quiz', [QuizController::class, 'store'])->name('save-quiz');