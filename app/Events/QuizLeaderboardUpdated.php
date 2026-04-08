<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizLeaderboardUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $quizId;
    public array $leaderboard;

    public function __construct(int $quizId, array $leaderboard)
    {
        $this->quizId = $quizId;
        $this->leaderboard = $leaderboard;
    }

    public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('quiz.' . $this->quizId);
    }

    public function broadcastAs(): string
    {
        return 'leaderboard.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'quiz_id' => $this->quizId,
            'leaderboard' => $this->leaderboard,
        ];
    }
}