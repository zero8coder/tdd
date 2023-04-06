<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @test
     * 获取用户最近回复
     */
    public function a_user_can_fetch_their_most_recent_reply()
    {
       $user = User::factory()->create();
       $reply = Reply::factory()->create(['user_id' => $user->id]);
       $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /**
     * @test
     * 用户可以决定他们的头像
     */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = User::factory()->create();
        $this->assertEquals('avatars/default.jpg', $user->user_avatar);
        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals('avatars/me.jpg', $user->user_avatar);
    }
}
