<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     * 一个用户可以浏览所有帖子
     */
    public function a_user_can_view_all_threads()
    {
        $thread = Thread::factory()->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    /**
     * @test
     * 一个用户可以浏览帖子
     */
    public function a_user_can_read_a_signle_thread()
    {
        $thread = Thread::factory()->create();
        $response = $this->get('/threads/' . $thread->id);
        $response->assertSee($thread->title);
    }

}
