<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 多态关联
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * 点赞回复
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if ( ! $this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
        return false;
    }

    /**
     * 是否点赞过这个回复
     * @return bool
     */
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
