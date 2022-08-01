<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 28/03/2020
 * Time: 14:43
 */

namespace App\Listeners;


use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class MessageWasCreated extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\Message
     */
    private $message;

    /**
     * MessageWasCreated constructor.
     * @param \App\Models\Message $message
     */
    public function __construct(Message $message)
    {
        $this->message($message);
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);
    }
    public function toArray($notifiable):array {
        return [];
    }
}
