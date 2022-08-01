<?php

declare(strict_types=1);

namespace App\Models\Participant;

use App\Models\Conversation\Name;
use App\Models\Participant;

/**
 * Class UpdateConversationName.
 */
class UpdateConversationName
{
    /**
     * @param \App\Models\Participant $participant
     *
     * @throws \App\Models\Conversation\UndilutedParticipant
     */
    public function created(Participant $participant): void
    {
        /**
         * @var \App\Models\Conversation
         */
        $conversation = $participant->conversation;

        Name::addParticipantName($conversation, $participant);
    }

    /**
     * @param \App\Models\Participant $participant
     *
     * @return void
     */
    public function deleted(Participant $participant): void
    {
        /**
         * @var \App\Models\Conversation
         */
        $conversation = $participant->conversation;

        Name::removeParticipantName($conversation, $participant);
    }
}
