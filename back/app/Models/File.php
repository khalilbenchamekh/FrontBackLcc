<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];

    public function businessManagement()
    {
        return $this->belongsTo(BusinessManagement::class,"business_id",'id');
    }
}
