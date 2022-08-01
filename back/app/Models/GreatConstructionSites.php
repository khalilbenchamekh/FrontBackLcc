<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GreatConstructionSites extends Model
{
    protected $table = 'g_c_s';

    public function businessManagement ()
    {
        $this->morphOne(BusinessManagement::class, 'membership');
    }
    protected $guarded = ['id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function allocatedBrigades()
    {
      return $this->belongsToMany(AllocatedBrigade::class, 'g_c_s_a_b','g_c_id','a_b_id');

    }
}
