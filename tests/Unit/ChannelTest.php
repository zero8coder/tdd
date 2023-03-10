<?php

namespace Tests\Unit;


use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * 一个频道包含了多个帖子
     */
    public function a_channel_consists_of_threads()
    {
        $channel = Channel::factory()->create();
        $thread = Thread::factory()->create(['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
