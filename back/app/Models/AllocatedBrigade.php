<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AllocatedBrigade extends Model
{
    protected $table = 'allocated_brigades';
    protected $fillable = ['name'];
    public function greatConstructionSites()
    {
        return $this->belongsToMany(GreatConstructionSites::class,'g_c_s_a_b','g_c_id','a_b_id');
    }
}
