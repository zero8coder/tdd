<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;

    }

    public function delete(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    public function create(User $user, Reply $reply)
    {
        if (!$lastReply = $user->fresh()->lastReply) {
            return true;
        }

        return !$lastReply->wasJustPublished();
    }

}
