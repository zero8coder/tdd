<?php

namespace Tests\Unit;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = Thread::factory()->create();
    }

    /**
     * @test
     * 一个帖子有回复
     */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
     * @test
     * 一个贴子有创建人
     */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\Models\User', $this->thread->creator);
    }

    /**
     * @test
     * 帖子添加回复
     */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * @test
     * 一个帖子有一个频道
     */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = Thread::factory()->create();
        $this->assertInstanceOf('App\Models\Channel', $thread->channel);
    }

    /**
     * @test
     */
    public function a_thread_can_make_a_string_path()
    {
        $thread = Thread::factory()->create();
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

}
