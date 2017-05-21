<?php

namespace App;

use App\Channel;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string  title
 * @property mixed   creator
 * @property mixed   replies
 * @property mixed   channel
 */
class Thread extends Model
{
    protected $guarded = [];

    /**
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Add a reply to a thread.
     *
     * @param $reply
     * @return $this
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);

        return $this;
    }
}
