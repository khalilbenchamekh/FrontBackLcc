<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
//    protected $table = 'messages as m';
    protected $fillable = [
        'content', 'from_id','to_id','read_at','created_at'
    ];
    protected $sates= ['read_at','created_at'];
    public $timestamps =false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from () {
        return $this->belongsTo('App\User','from_id');

    }  /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */

    public function files () {
        return $this->hasMany(MessageFile::class,'message_id','id');
    }

}
