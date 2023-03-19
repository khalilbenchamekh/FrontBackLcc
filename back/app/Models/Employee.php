<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['personal_number', 'profession_number', 'position_held', 'linked_documents', 'Start_date', 'Salary', 'workplace'];

    public function user()
    {
        return $this->morphOne(User::class, 'membership');
    }

    public function Documents()
    {
        return $this->hasMany(Linked_Documents::class);
    }


}
