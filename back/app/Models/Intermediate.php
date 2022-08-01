<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Intermediate extends Model
{
    protected $guarded = ['id'];

    public function affaire()
    {
        return $this->belongsTo(Affaire::class);
    }

    public function feesFolderTech()
    {
        return $this->belongsTo(FeesFolderTech::class);
    }
}
