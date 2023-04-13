<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property mixed id
 */
class Reply extends Model
{
    use HasFactory, Favoritable, RecordsActivity;

    protected static function boot()
    {
        parent::boot();
        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            if ($reply->id == $reply->thread->best_reply_id) {
                $reply->thread->update(['best_reply_id' => null]);
            }
            $reply->thread->decrement('replies_count');
        });
    }

    protected $fillable = [
        'body',
        'user_id'
    ];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['favoritesCount', 'created_at_see', 'isFavorited', 'isBest'];


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // 是否刚发布
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function getCreatedAtSeeAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }
        return '';
    }

    public function mentionedUsers()
    {
        preg_match_all('/@([\x{4e00}-\x{9fa5}\w]+)/u', $this->body, $matches);
        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\x{4e00}-\x{9fa5}\w]+)/u','<a href="/profiles/$1">$0</a>', $body);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }


}
