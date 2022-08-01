<?php

namespace App\Policies;

use App\User;

class UserPolicy
{

    public function talkTo(User $user,User $to){
        return $user->id !== $to->id;
    }
}
