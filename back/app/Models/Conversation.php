<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Participant\RoleType;
use App\Models\Traits\UuidTrait;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Conversation.
 */
class Conversation extends Model
{
    use UuidTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'name_type', 'type',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\User                      $user
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('participants', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id)
                ->whereNull('participants.deleted_at');
        });
    }

    /**
     * @param \App\User $user
     *
     * @return \App\Models\Participant|null
     */
    public function getParticipantFor(User $user): ?Participant
    {
        return $this->participants
            ->where('user_id', $user->id)
            ->first();
    }

    /**
     * @param \App\Models\Participant $participant
     *
     * @return bool
     */
    public function isParticipantBelongs(Participant $participant): bool
    {
        return $this->participants->where('id', $participant->id)->count() === 1;
    }

    /**
     * @param \App\User $user
     *
     * @return bool
     */
    public function isAdmin(User $user): bool
    {
        return optional($this->getParticipantFor($user))->role === RoleType::OWNER;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
