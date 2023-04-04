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
}
