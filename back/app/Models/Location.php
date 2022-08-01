<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public function greatConstructionSites(){
        return $this->belongsToMany(GreatConstructionSites::class);
    }

}
