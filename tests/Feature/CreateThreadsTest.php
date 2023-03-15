<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    /**
     * @test
     * 游客不能发布帖子
     */
    public function guests_may_not_create_threads()
    {
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads')->assertRedirect('/login');

    }

    /**
     * @test
     * 登录用户可以发布帖子
     */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        $thread = Thread::factory()->make();
        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * @test
     * 游客
     */
    public function guests_may_not_see_the_create_thread_page()
    {
        $this->get('/threads/create')->assertRedirect('/login');
    }

    // 发布帖子
    public function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = Thread::factory()->make($overrides);
        return $this->post('/threads', $thread->toArray());
    }


    /**
     * @test
     * 一个帖子有一个标题
     */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     * 一个帖子有一个内容
     */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     * 一个帖子有一个频道
     */
    public function a_thread_requires_a_valid_channel()
    {
        Channel::factory()->count(2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');

    }
}
