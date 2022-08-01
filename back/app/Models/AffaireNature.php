<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AffaireNature extends Model
{
    protected $guarded = ['id'];
    protected $fillable=['Name','organisation_id',"Abr_v"];
    public function affaires(){

        return $this->hasMany(Affaire::class);
    }


}
