<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Event\MessageCreated;

/**
 * Class BroadcastMessageCreated.
 */
class BroadcastMessageCreated
{
    /**
     * @param \App\Event\MessageCreated $messageCreated
     *
     * @return void
     */
    public function handle(MessageCreated $messageCreated): void
    {
        /**
         * @var \App\Models\Participant[]
         */
        $message = $messageCreated->getMessage();
        $message->load(['conversation', 'conversation.participants']);
        $participants = $message->conversation->participants;

        foreach ($participants as $participant) {
             $participant->user->notify(new MessageWasCreated($message));
        }
    }
}
