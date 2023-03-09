<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * 未登录用户不能回复帖子
     */
    public function unauthenticated_user_may_not_add_replies()
    {
        // 一个帖子
        $thread = Thread::factory()->create();
        // 回复帖子
        $reply = Reply::factory()->create();
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(302);
    }

    /**
     * @test
     * 登录用户可以回复帖子
     */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // 登录用户
        $this->be($user = User::factory()->create());
        // 一个帖子
        $thread = Thread::factory()->create();
        // 回复帖子
        $reply = Reply::factory()->make(['user_id' => $user->id, 'thread_id' => $thread->id]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(302);
        // 能看到回复的内容
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
