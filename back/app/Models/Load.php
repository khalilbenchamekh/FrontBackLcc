<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    protected $guarded = ['id'];

    public function load_related_to()
    {
        return $this->belongsTo(User::class);
    }

    public function loadType()
    {
        return $this->belongsTo(LoadTypes::class);
    }

    public function fileLoad(){

        return $this->hasMany(FileLoad::class);
    }

}
