<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateThreadsTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 话题创建者才能更新
     * @test
     */
    public function unauthorized_users_may_not_update_threads()
    {
        $thread = Thread::factory()->create([
            'user_id' => User::factory()->create()->id
        ]);

        $this->patch($thread->path(), [])->assertStatus(403);
    }

    /**
     * @test
     * 更新的字段要符合规则
     */
    public function a_thread_requires_a_title_and_body_to_be_updated()
    {
        $thread = Thread::factory()->create([
            'user_id' => auth()->id()
        ]);
        $this->patch($thread->path(), ['title' => 'Changed.'])
            ->assertSessionHasErrors('body');

        $this->patch($thread->path(), ['body' => 'Changed.'])
            ->assertSessionHasErrors('title');
    }

    /**
     *
     * @test
     * 话题成功更新
     */

    public function a_thread_can_be_updated_by_its_creator()
    {
        $thread = Thread::factory()->create([
            'user_id' => auth()->id()
        ]);
        $this->patch($thread->path(), [
            'title' => 'Changed.',
            'body' => 'Changed body'
        ]);
        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('Changed.', $thread->title);
            $this->assertEquals('Changed body', $thread->body);
        });
    }


}
