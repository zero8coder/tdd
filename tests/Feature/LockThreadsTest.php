<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    /**
     * 话题被锁定 不能回复
     * @test
     */
    public function once_locked_thread_may_not_receive_new_replies()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        $thread->lock();
        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(422);

    }
}
