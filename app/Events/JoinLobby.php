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

class JoinLobby implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;
    public int $userId;
    public string $quizCode;
    public string $username;
    /**
     * Create a new event instance.
     */
    public function __construct(int $userId, string $quizCode, string $username)
    {
        $this->userId = $userId;
        $this->quizCode = $quizCode;
        $this->username = $username;
    }

    public function broadcastToEveryone(): bool
    {
        return true;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('join-lobby.' . $this->quizCode),
        ];
    }

    public function broadcastWith(): array {
        return ['userId' => $this->userId, 'username' => $this->username];
    }
}
