<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TypesCharge extends Model
{
    protected $guarded = ['id'];
    protected $table = 'typescharges';
    public function charges()
    {
        return $this->hasMany(Charges::class);
    }
}
