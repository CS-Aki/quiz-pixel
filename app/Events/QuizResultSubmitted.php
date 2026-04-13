<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizResultSubmitted implements ShouldBroadcastNow
{
    public function __construct(public string $quizCode, public $result) {}

    public function broadcastOn(): Channel
    {
        return new Channel('quiz-results.' . $this->quizCode);
    }

    public function broadcastAs(): string
    {
        return 'result.submitted';
    }

    public function broadcastWith(): array
    {
        return [
            'result' => [
                'player_name'        => trim($this->result->user?->first_name . ' ' . $this->result->user?->last_name) ?: 'Unknown Player',
                'score'              => $this->result->score,
                'correct_count'      => $this->result->correct_count,
                'total_questions'    => $this->result->total_questions,
                'time_taken_seconds' => $this->result->time_taken_seconds ?? 0,
            ]
        ];
    }
}
