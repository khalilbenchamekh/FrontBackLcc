<?php

declare(strict_types=1);

namespace App\Models\Conversation;

use App\Models\Conversation;
use App\Models\Participant;
use Exception;

/**
 * Class UndilutedParticipant.
 */
class UndilutedParticipant extends Exception
{
    /**
     * UndilutedParticipant constructor.
     *
     * @param \App\Models\Participant  $participant
     * @param \App\Models\Conversation $conversation
     */
    public function __construct(Participant $participant, Conversation $conversation)
    {
        parent::__construct(
            sprintf('Participant [%s] can not be added to conversation [%s]', $participant->id, $conversation->id)
        );
    }
}
