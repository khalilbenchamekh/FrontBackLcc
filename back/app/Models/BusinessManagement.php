<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessManagement extends Model
{
    protected $table = 'business_managements';

    public function membership()
    {
        return $this->morphTo();
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function fees()
    {
        return $this->hasMany(Fees::class);
    }
}
