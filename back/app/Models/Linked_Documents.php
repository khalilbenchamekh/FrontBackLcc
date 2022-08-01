<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Linked_Documents extends Model
{
    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
