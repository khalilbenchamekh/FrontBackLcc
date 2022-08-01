<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function details(){

        return $this->hasMany(BillDetail::class);
    }
}
