<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * @test
     * 用户订阅帖子能收到最新回复
     */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        // 帖子
        $thread = Thread::factory()->create();
        // 订阅帖子
        $thread->subscribe();
        $this->assertCount(0, auth()->user()->notifications);
        // 帖子追加一个回复
        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Some reply here'
        ]);
        // 能看到一个新的提醒
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // 帖子追加一个回复
        $thread->addReply([
            'user_id' => User::factory()->create()->id,
            'body'    => 'Some reply here'
        ]);
        // 能看到一个新的提醒
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /**
     * @test
     * 用户查没有阅读的通知
     */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->addNotification();
        $user = auth()->user();
        // 查看通知
        $response = $this->getJson('/profiles/' . urlencode($user->name) . '/notifications')->json();
        $this->assertCount(1, $response);

    }

    /**
     * @test
     * 用户可以清除一个通知
     */
    public function a_user_can_clear_a_notification()
    {
        $this->addNotification();
        $user = auth()->user();
        $this->assertCount(1, $user->unreadNotifications);
        $notificationId = $user->unreadNotifications->first()->id;
        $this->delete("/profiles/" . urlencode($user->name) . "/notifications/{$notificationId}")->assertStatus(200);
        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }

    // 添加通知
    private function addNotification()
    {
        $thread = Thread::factory()->create()->subscribe();
        $thread->addReply([
            'user_id' => User::factory()->create(),
            'body'    => '回复测试'
        ]);

        return $thread;
    }
}
