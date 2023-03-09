<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

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
        $this->signIn(User::factory()->create());
        $thread = Thread::factory()->create();
        $this->post('/threads', $thread->toArray())
            ->assertStatus(302);

        $this->get($thread->path())
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
}
