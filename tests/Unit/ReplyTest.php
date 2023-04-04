<?php

namespace Tests\Unit;

use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
class ReplyTest extends TestCase
{

    /**
     * @test
     * 回复有回复人
     */
    public function a_reply_has_an_owner()
    {
        $reply =  Reply::factory()->create();
        $this->assertInstanceOf('App\Models\User', $reply->owner);
    }

    /**
     * @test
     * 回复是否是刚发布
     */
    public function it_knows_if_it_was_just_published()
    {
        $reply = Reply::factory()->create();
        $this->assertTrue($reply->wasJustPublished());
    }
}
