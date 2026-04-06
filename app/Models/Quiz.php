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

    protected $casts = [
        'user_limit' => 'integer',
    ];
}