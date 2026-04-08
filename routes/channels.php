<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('join-lobby.{code}', function ($user, $code) {
    return [
        'id' => $user->id,
        'username' => $user->username,
        'name' => $user->first_name,
    ];
});

Broadcast::channel('quiz.{quizId}', function ($user, $quizId) {
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});