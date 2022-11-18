<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class business extends Model
{
    public function client ()
    {
        $this->morphOne(Client::class, 'membership');
    }
}
