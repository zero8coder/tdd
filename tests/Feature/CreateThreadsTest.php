<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
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
     * 发布帖子前必须先确认邮箱
     */
    public function authenticated_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = User::factory()->create(['confirmed' => false]);
        $this->publishThread([], $user)
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', '你先确认邮箱');
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
    public function publishThread($overrides = [], $user = null)
    {
        $this->signIn($user);
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
            ->assertStatus(302);
    }

    /**
     * @test
     * 一个帖子有一个内容
     */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertStatus(302);
    }

    /**
     * @test
     * 一个帖子有一个频道
     */
    public function a_thread_requires_a_valid_channel()
    {
        Channel::factory()->count(2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertStatus(302);

        $this->publishThread(['channel_id' => 999])
            ->assertStatus(302);

    }

    /**
     * @test
     *一个帖子要求一个唯一概括
     */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = Thread::factory()->create([
            'title' => 'Foo Title',
            'slug' => 'foo-title'
        ]);

        $this->assertEquals($thread->slug, 'foo-title');

        $this->post(route('threads'), $thread->toArray());
        // 相同话题的 Slug 后缀会加 1，即 foo-title-2
        $this->assertTrue(Thread::where('slug', 'foo-title-2')->exists());

        $this->post(route('threads'), $thread->toArray());
        // 相同话题的 Slug 后缀会加 1，即 foo-title-3
        $this->assertTrue(Thread::where('slug', 'foo-title-3')->exists());
    }

    /**
     * @test
     * 登录用户可以删除自己的帖子
     */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();
        $thread = Thread::factory()->create(['user_id' => auth()->id()]);
        $reply = Reply::factory()->create(['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    /**
     * @test
     * 未授权用户不能删除帖子
     */
    public function unauthorized_users_may_not_delete_threads()
    {
        $thread = Thread::factory()->create();
        $this->delete($thread->path())->assertRedirect('/login');
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

}
