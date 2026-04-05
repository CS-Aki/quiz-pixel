<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing-page');
});

Route::get('/login', function () {
    return view('login-page');
});

Route::get('/register', function () {
    return view('register-page');
});