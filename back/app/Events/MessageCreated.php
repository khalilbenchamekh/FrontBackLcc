<?php

declare(strict_types=1);

namespace App\Event;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

/**
 * Class MessageCreated.
 */
class MessageCreated implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var \App\Models\Message
     */
    private $message;

    /**
     * MessageCreated constructor.
     *
     * @param \App\Models\Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return \App\Models\Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @return \Illuminate\Broadcasting\PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('conversation.'.$this->message->conversation->id);
    }

    /**
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'message.created';
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
