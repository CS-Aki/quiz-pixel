<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'quiz_id',
        'question',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'answer_key',
        'time_limit',
        'points',
    ];

    /**
     * A question belongs to a quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    protected $casts = [
        'time_limit' => 'integer',
        'points' => 'integer',
    ];
}