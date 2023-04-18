<?php

namespace App\Models;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

/**
 * Thread
 *
 * @mixin Eloquent
 */
class Thread extends Model
{
    use HasFactory, RecordsActivity,Searchable;

    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'body',
        'visits',
        'slug',
        'best_reply_id',
        'locked'
    ];

    protected $with = [
        'creator', 'channel'
    ];

    protected $appends = [
        'created_at_see',
        'isSubscribedTo'
    ];

    protected $casts = [
        'locked' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });

        static::created(function ($thread) {
           $thread->update([
               'slug' => $thread->title
           ]);
        });

    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // 帖子的路径
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->slug}";
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

        event(new ThreadReceivedNewReply($reply));

        return $reply;

    }

    // 通知所有订阅
    public function notifySubscribers($reply)
    {
        $this->subscriptions
            ->where('user_id','!=',$reply->user_id)
            ->each
            ->notify($reply);
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

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }

    public function visits()
    {
        return new Visits($this);
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);
        if (static::where('slug', $slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function markBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }
}
