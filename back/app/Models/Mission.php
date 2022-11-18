<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $guarded = ['id'];
    public function User()
    {
        return $this->hasOne(User::class);
    }
}
