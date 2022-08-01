<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderTechSituation extends Model
{
    protected $guarded = ['id'];
    protected $table = 'foldertechsituations';
    public function folderTechs()
    {
        return $this->hasMany(FolderTech::class);
    }
}
