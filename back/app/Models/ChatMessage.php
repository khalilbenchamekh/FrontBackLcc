<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $visible = [
        'id',
        'text',
    ];

    protected $fillable = [
        'chat_id',
        'user_id',
        'text',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
