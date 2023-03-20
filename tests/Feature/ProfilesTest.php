<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    /**
     * @test
     * 用户有一个简介
     */
    public function a_user_has_a_profile()
    {
        $user = User::factory()->create();
        $this->get('/profiles/' . urlencode($user->name))
            ->assertSee($user->name);
    }

//    /**
//     * @test
//     * 简介展示用户所有的帖子
//     */
//    public function profiles_display_all_threads_created_by_the_associated_user()
//    {
//        $user = User::factory()->create();
//        $thread = Thread::factory()->create(['user_id' => $user->id]);
//        $this->get("/profiles/" . urlencode($user->name))
//            ->assertStatus(200)
//            ->assertSee($thread->title)
//            ->assertSee($thread->body);
//    }
}
