<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LoadTypes extends Model
{
    protected $guarded = ['id'];
    public function loads(){
        return $this->hasMany(Load::class);
    }
}
