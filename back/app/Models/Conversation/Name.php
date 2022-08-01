<?php

declare(strict_types=1);

namespace App\Models\Conversation;

use App\Models\Conversation;
use App\Models\Participant;
use Illuminate\Support\Str;

/**
 * Class Name.
 */
class Name
{
    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     *
     * @throws \App\Models\Conversation\UndilutedParticipant
     *
     * @return void
     */
    public static function addParticipantName(Conversation $conversation, Participant $participant): void
    {
        if (!static::shouldAddParticipantName($conversation, $participant)) {
            throw new UndilutedParticipant($participant, $conversation);
        }

        $conversation->update([
            'name' => $conversation->name === null
                ? $participant->user->name
                : $conversation->name.', '.$participant->user->name,
        ]);
    }

    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     */
    public static function removeParticipantName(Conversation $conversation, Participant $participant): void
    {
        if (!static::shouldRemoveParticipantName($conversation, $participant)) {
            return; //TODO
        }

        $conversation->update([
            'name' => Str::replaceFirst(', '.$participant->user->name, '', $conversation->name),
        ]);
    }

    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     *
     * @return bool
     */
    public static function shouldAddParticipantName(Conversation $conversation, Participant $participant): bool
    {
        return static::shouldModify($conversation, $participant) && static::doesNotContainsParticipantName($conversation, $participant);
    }

    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     *
     * @return bool
     */
    public static function shouldRemoveParticipantName(Conversation $conversation, Participant $participant): bool
    {
        return static::shouldModify($conversation, $participant) && static::containsParticipantName($conversation, $participant);
    }

    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     *
     * @return bool
     */
    protected static function shouldModify(Conversation $conversation, Participant $participant): bool
    {
        return $conversation->name_type !== NameType::MANUALLY_SPECIFIED
            && $conversation->isParticipantBelongs($participant);
    }

    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     *
     * @return bool
     */
    protected static function doesNotContainsParticipantName(Conversation $conversation, Participant $participant): bool
    {
        return !static::containsParticipantName($conversation, $participant);
    }

    /**
     * @param \App\Models\Conversation $conversation
     * @param \App\Models\Participant  $participant
     *
     * @return bool
     */
    protected static function containsParticipantName(Conversation $conversation, Participant $participant): bool
    {
        return Str::startsWith($participant->user->name, $conversation->name)
            || Str::contains(', '.$participant->user->name, $conversation->name);
    }
}
