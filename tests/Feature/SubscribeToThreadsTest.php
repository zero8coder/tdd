<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    /**
     * @test
     * 用户可以订阅帖子
     */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        $this->post($thread->path() . '/subscriptions')->assertStatus(200);
        $this->assertCount(1, $thread->subscriptions);
    }

    /**
     * @test
     * 用户可以取消订阅帖子
     */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        $this->post($thread->path() . '/subscriptions')->assertStatus(200);
        $this->assertCount(1, $thread->subscriptions);
        $this->delete($thread->path() . '/subscriptions')->assertStatus(200);
        $this->assertCount(0, $thread->refresh()->subscriptions);
    }



}
