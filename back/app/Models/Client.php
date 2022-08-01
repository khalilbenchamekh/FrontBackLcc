<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = ['id'];

    public function affaires()
    {
        return $this->hasMany(Affaire::class);
    }

    public function folderTechs()
    {
        return $this->hasMany(FolderTech::class);
    }
    public function membership ()
    {
        return $this->morphTo();
    }

}
