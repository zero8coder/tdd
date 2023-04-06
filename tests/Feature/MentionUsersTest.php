<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    /**
     * @test
     *  通知被@的人
     */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = User::factory()->create(['name' => 'John']);
        $this->signIn($john);

        $jane = User::factory()->create(['name' => 'jane']);
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make([
            'body' => '@jane 看这， @Luke也是'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);

    }
}
