<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('logs', function () {
    $user = Auth::User();
    if(!$user && isset($user) && ($user!==null)){
        return $user->hasRole('owner');
    }
    return false;
}
);

Broadcast::channel('countDown', function () {
    $user = Auth::User();
    if(!$user && isset($user) && ($user!==null)){
        return $user->hasRole('owner');
    }
    return false;
}
);

