<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    public function bills(){
        return $this->belongsTo(Bill::class,"bills_id");
    }
}
