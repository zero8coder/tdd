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
        $reply = Reply::factory()->create();
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

    /**
     * @test
     * 获取所有被@的账号
     */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = Reply::factory()->create([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    /**
     * @test
     * @的人追加链接
     */
    public function it_warps_mentioned_usernames_in_the_body_within_archor_tags()
    {
        $reply = Reply::factory()->create(['body' => '你好 @Jane-Doe。']);

        $this->assertEquals(
            '你好 <a href="/profiles/Jane-Doe">@Jane-Doe</a>。',
            $reply->body
        );
    }
}
