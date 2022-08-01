<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderTechNature extends Model
{
    protected $guarded = ['id'];

    public function folderTechs()
    {
        return $this->hasMany(FolderTech::class);
    }

}
