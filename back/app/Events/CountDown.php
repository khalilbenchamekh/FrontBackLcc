<?php

namespace App\Events;

use App\Models\BusinessManagement;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class CountDown implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $collection;


    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('countDown');
    }

    public function broadcastAs()
    {
        return 'newCountDown';
    }
}
