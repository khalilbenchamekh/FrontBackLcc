<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FolderTech extends Model
{
    protected $table = 'folderteches';

    protected $guarded = ['id'];

    public function folderTechNature(){
        return $this->belongsTo(FolderTechNature::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function folderTechSituation(){
        return $this->belongsTo(FolderTechSituation::class);
    }

    public function intermediate()
    {
        return $this->hasOne(Intermediate::class);
    }
    public function businessManagement ()
    {
        $this->morphOne(BusinessManagement::class, 'membership');
    }

}
