<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Reply extends Model
{
    use HasFactory, Favoritable, RecordsActivity;

    protected $fillable = [
        'body',
        'user_id'
    ];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['favoritesCount', 'created_at_see'];


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
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

}
