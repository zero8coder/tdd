<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Exception;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{

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
        $user = User::factory()->create();
        $this->signIn($user);
        // 一个帖子
        $thread = Thread::factory()->create();
        // 回复帖子
        $reply = Reply::factory()->make(['user_id' => $user->id, 'thread_id' => $thread->id]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);
        // 能看到回复的内容
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1,$reply->thread->fresh()->replies_count);


    }

    /**
     * @test
     * 回复内容必填
     */
    public function a_reply_requires_a_body()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make(['body' => null]);
        $this->json('post', $thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /**
     * @test
     * 未登录用户不能删除回复
     */
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply = Reply::factory()->create();
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);

    }

    /**
     * @test
     * 登录用户可以删除自己的回复
     */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = Reply::factory()->create(["user_id" => auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(200);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0,$reply->thread->fresh()->replies_count);
    }

    /**
     * @test
     * 未授权用户不能修改回复
     */
    public function unauthorized_users_cannot_update_replies()
    {
        // 创建回复
        $reply = Reply::factory()->create();
        // 未登录用户重定向到登录页
        $this->patch('/replies/' . $reply->id)->assertStatus(302)->assertRedirect('/login');
        // 登录了无权限用户提示未授权
        $this->signIn()->patch('/replies/' . $reply->id)->assertStatus(403);
    }

    /**
     * @test
     * 授权用户可以修改回复
     */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = Reply::factory()->create(['user_id' => auth()->id()]);
        $this->patch('/replies/' . $reply->id, ['body' => 3333])->assertStatus(200);
    }

    /**
     * @test
     * 回复有禁止的词汇不给创建
     */
    public function replies_contain_spam_may_not_be_created()
    {
        $this->signIn();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make([
            'body' => 'something forbidden'
        ]);

        $this->json('post', $thread->path() . '/replies',$reply->toArray())
        ->assertStatus(422);
    }

    /**
     * @test
     * 用户一分钟只能回复一次
     */
    public function users_may_only_reply_a_maximum_of_once_per_minute()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        $reply = Reply::factory()->make(['body' => '简易回复']);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);
    }


}
