<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritiesTest extends TestCase
{
    /**
     * @test
     * 游客不能点赞回复
     *
     */
    public function guests_can_not_favorite_anything()
    {
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /**
     * @test
     * 用户可以点赞任意回复
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = Reply::factory()->create();
        // 如果点赞了回复
        $this->post('replies/' . $reply->id . '/favorites');
        // 会有一条记录在数据库
        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     * 用户不能重复点赞
     */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = Reply::factory()->create();
        try{
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('用户不能重复点赞');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
