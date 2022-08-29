<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use App\Models\Chat;
use App\Models\Load;
use App\Models\Message;
use App\Models\Participant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }


    public function membership()
    {
        return $this->morphTo();
    }

    public function organisation()
    {
        return $this->hasOne(Organisation::class);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }
  
    public function getHasEmployeeProfileAttribute()
    {
        return $this->membership_type == 'App\Models\Employee';
    }

    public function loads()
    {

        return $this->hasMany(Load::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'from_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->roles != [] ? $this->roles[0]->name : 'user',
        ];
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }
}
