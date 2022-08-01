<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fileLoad extends Model
{
    public function loadType()
    {
        return $this->belongsTo(Load::class,"load_id",'id');
    }
}
