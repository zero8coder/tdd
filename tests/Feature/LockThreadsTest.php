<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    /**
     * 帖子被锁定 不能回复
     * @test
     */
    public function once_locked_thread_may_not_receive_new_replies()
    {
        $this->signIn();
        $thread = Thread::factory()->create(['locked' => true]);
        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(422);

    }

    /**
     * 非管理员不能锁定帖子
     * @test
     */
    public function non_administrator_may_not_lock_threads()
    {
        $this->signIn();
        $thread = Thread::factory()->create([
            'user_id' => auth()->id()
        ]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /**
     * 管理员可以锁定帖子
     * @test
     */
    public function administrators_can_lock_threads()
    {
        $this->signInAdmin();
        $thread = Thread::factory()->create(['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue(!! $thread->fresh()->locked);
    }

    /**
     * 管理员可以解锁帖子
     * @test
     */
    public function administrators_can_unlock_threads()
    {
        $this->signInAdmin();
        $thread = Thread::factory()->create([
            'user_id' => auth()->id(),
            'locked' => true
        ]);

        $this->delete(route('locked-threads.destroy', $thread));
        $this->assertFalse($thread->fresh()->locked);
    }

}
