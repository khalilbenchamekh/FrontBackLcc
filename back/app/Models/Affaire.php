<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Affaire extends Model
{
    protected $guarded = ['id'];

    public function affaireNature(){
        return $this->belongsTo(AffaireNature::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function affaireSituation(){
        return $this->belongsTo(AffaireSituation::class);
    }

    public function intermediate()
    {
        return $this->hasOne(Intermediate::class);
    }
    public function businessManagement ()
    {
        $this->morphOne(BusinessManagement::class, 'membership');
    }

}
