<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{

    protected $fillable = [
        'name', 'email'
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
