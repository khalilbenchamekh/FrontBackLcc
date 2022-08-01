<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffaireSituation extends Model
{
    protected $table = 'affairesituations';
    protected $guarded = ['id'];
    public function affaires(){

        return $this->hasMany(Affaire::class);
    }

}
