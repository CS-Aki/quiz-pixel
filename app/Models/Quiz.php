<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'code',
        'title',
        'description',
        'status',
        'user_limit',
        'user_id',
    ];

    /**
     * A quiz has many questions
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    protected $casts = [
        'user_limit' => 'integer',
    ];

}