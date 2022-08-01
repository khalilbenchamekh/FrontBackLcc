<?php

namespace App\Events;

use App\Models\LogActivity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogActivityCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $logActivity;

    public function __construct(LogActivity $activity)
    {
        $this->logActivity = $activity;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('logs');
    }
    public function broadcastAs()
    {
        return 'newLogs';
    }
}
