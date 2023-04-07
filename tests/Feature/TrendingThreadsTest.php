<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\Trending;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    private $trending;
    protected function setUp(): void
    {
        parent::setUp();
        $this->trending = new Trending();
        $this->trending->reset();
    }

    /**
     * @test
     */
    public function it_increments_a_thread_score_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());
        $thread = Thread::factory()->create();
        $this->call('GET', $thread->path());
        $trending = $this->trending->get();
        $this->assertCount(1, $trending);
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
