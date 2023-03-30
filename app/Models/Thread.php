<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'created_at_see'
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
        return $this->replies()->create($reply);
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

}
