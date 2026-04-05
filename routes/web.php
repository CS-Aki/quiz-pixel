<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
});

Route::get('/login', [LoginController::class, 'index'])->name("to-login");
Route::post('/login-user', [LoginController::class, 'login'])->name("login");

Route::get('/register', [RegisterController::class, 'index'])->name("to-register");
Route::post('/register-user', [RegisterController::class, 'register'])->name("register");

Route::post('/login-user', function (Request $request) {
    return response()->json([
        'success' => true,
        'received' => $request->all(),
    ]);
});