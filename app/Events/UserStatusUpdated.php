<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('users');
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->user->id,
            'is_online' => $this->user->is_online,
            'last_seen_at' => $this->user->last_seen_at ? $this->user->last_seen_at->toDateTimeString() : null,
        ];
    }
}
