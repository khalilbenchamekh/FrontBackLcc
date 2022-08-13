<?php

namespace App\Policies;

use App\Models\Message;
use App\User;

class MessagePolicy
{

    public function talkTo(User $user,Message $message){

        return $user->id !== $message->to_id || $message->organisation_id === $user->organisation_id;
    }
}
