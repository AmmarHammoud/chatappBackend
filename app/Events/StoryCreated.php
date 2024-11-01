<?php
namespace App\Events;

use App\Models\Story;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class StoryCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    public function broadcastOn()
    {
        return new Channel('stories');
    }
}
