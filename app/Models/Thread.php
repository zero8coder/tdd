<?php

namespace App\Models;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Thread
 *
 * @mixin Eloquent
 */
class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'body'
    ];

    protected $with = [
        'creator','channel'
    ];

    protected $appends = [
        'created_at_see',
        'isSubscribedTo'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

    }

    // 帖子的路径
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    // 帖子的回复
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // 帖子创建者
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); // 使用 user_id 字段进行模型关联
    }

    // 添加回复
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);
        // 通知所有订阅
        $this->subscriptions
            ->filter(function ($sub) use ($reply) {
            return $sub->user_id != $reply->user_id;
        })->each->notify($reply);
        return $reply;

    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getCreatedAtSeeAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }

        return '';
    }

    // 订阅
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $userId = $userId ?: auth()->id();
        $this->subscriptions()->where('user_id', $userId)->delete();
        return $this;
    }

    /**
     * 订阅的人
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * 是否被当前用户订阅
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
