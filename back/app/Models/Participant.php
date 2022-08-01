<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\UuidTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Participant.
 */
class Participant extends Model
{
    use UuidTrait, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'conversation_id', 'user_id', 'role', 'last_read_at',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'updated_at', 'created_at', 'last_read_at', 'deleted_at',
    ];

    /**
     * @var array
     */
    protected $with = [
        'user',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
