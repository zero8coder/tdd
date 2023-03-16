<?php

namespace Tests\Unit;


use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
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


}
