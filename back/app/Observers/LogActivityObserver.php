<?php

namespace App\Observers;

use App\Events\LogActivityCreated;
use App\Models\LogActivity;

class LogActivityObserver
{
    public function created(LogActivity $activity)
    {
        broadcast(new LogActivityCreated($activity));
    }
}
