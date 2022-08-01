<?php

namespace App\Observers;


use App\Models\ChatMessage;
use App\Events\ChatMessageCreated as ChatMessageCreatedEvent;
class ChatMessageObserver
{

    public function created(ChatMessage $chatMessage)
    {
        broadcast(new ChatMessageCreatedEvent($chatMessage));
    }


    public function updated(ChatMessage $chatMessage)
    {
        //
    }

    public function deleted(ChatMessage $chatMessage)
    {
        //
    }

    public function restored(ChatMessage $chatMessage)
    {
        //
    }


    public function forceDeleted(ChatMessage $chatMessage)
    {
        //
    }
}
