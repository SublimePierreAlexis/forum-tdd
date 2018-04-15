<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int    id
 * @property string name
 * @property string email
 * @property string avatar_path
 * @property bool   confirmed
 * @property null   confirmation_token
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * A user can have many threads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @param Thread $thread
     *
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", auth()->id(), $this->id);
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;

        $this->save();
    }

    /**
     * Check if a user is an administrator
     * @return bool
     */
    public function isAdmin()
    {
        return in_array($this->name, ['JohnDoe', 'JaneDoe']);
    }

    /**
     * @param $thread
     */
    public function read($thread)
    {
        cache()->forever(
            auth()->user()->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    /**
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? 'storage/' . $avatar : 'images/avatars/default.png');
    }

    /**
     * @return null|Reply
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }
}
