<?php

namespace Tests\Unit;


use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /**
     * @test
     * 发布帖子时生成活动流
     */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = Thread::factory()->create();
        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /**
     * @test
     * 回复时生成活动流
     */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = Reply::factory()->create();
        $this->assertEquals(2, Activity::count());

    }

    /**
     * @test
     *
     */

    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();
        Thread::factory()->count(2)->create(['user_id' => auth()->id()]);
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }

}
