<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected  $thread;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = Thread::factory()->create();
    }

    /**
     * @test
     * 一个用户可以浏览所有帖子
     */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     * 一个用户可以浏览帖子
     */
    public function a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }

    /**
     * @test
     * 用户可以能看到帖子的内容 也能看到回复
     */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // 如果存在帖子
        // 并且该帖子拥有回复
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);
        // 那么当我们看该帖子时
        // 我们也要看到回复
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /**
     * @test
     * 用户可以根据频道筛选帖子
     */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = Channel::factory()->create();
        $threadInChannel = Thread::factory()->create(['channel_id' => $channel->id]);
        $threadNotInChannel = Thread::factory()->create();
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

}
