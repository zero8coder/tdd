<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{

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
     * 一个帖子可以通知所有订阅者当一个回复被添加时
     */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();
        $this->signIn()
            ->thread->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => 999
            ]);

        Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);
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
    public function thread_has_a_path()
    {
        $thread = Thread::factory()->create();
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->slug}", $thread->path());
    }

    /**
     * @test
     * 一个帖子能被订阅
     */
    public function a_thread_can_be_subscribed_to()
    {
        // 创建一个帖子
        $thread = Thread::factory()->create();
        // 一个登录用户
        $this->signIn();
        // 帖子被订阅
        $thread->subscribe();
        // 帖子被订阅的人里有登录用户
        $num = $thread->subscriptions()->where('user_id', auth()->id())->count();
        $this->assertEquals(1, $num);
    }

    /**
     * @test
     * 一个帖子能取消订阅
     */
    public function a_thread_can_be_unsubscribed_from()
    {
        // 创建一个帖子
        $thread = Thread::factory()->create();
        // 帖子订阅
        $thread->subscribe($userId = 1);
        // 帖子取消订阅
        $thread->unsubscribe($userId);
        $this->assertCount(0 ,$thread->subscriptions);
    }

    /**
     * @test
     * 是否被授权用户订阅
     */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        // 帖子
        $thread = Thread::factory()->create();
        $this->signIn();
        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }

    /**
     * @test
     * 一个帖子检测用户是否读取过所有回复
     */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        tap(auth()->user(), function ($user) use ($thread)  {
            // 对标题进行加粗显示
            $this->assertTrue($thread->hasUpdatesFor($user));
            // 浏览话题
            $user->read($thread);
            // 取消加粗
            $this->assertFalse($thread->hasUpdatesFor($user));
        });
    }
}
