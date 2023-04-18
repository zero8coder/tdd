<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    /**
     * 用户可以搜索话题
     * @test
     */
    public function a_user_can_search_threads()
    {
        // 启用驱动
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';
        Thread::factory()->count(2)->create();
        Thread::factory()->count(2)->create(['body' => "A thread with {$search} term."]);
        // 由于网络等因素，所以我们进行以下处理
        do {
            sleep(2);
            $results = $this->getJson("/threads/search?q={$search}")->json();
        } while (empty($results));
        $this->assertCount(2, $results['data']);
        // 删除测试数据
        Thread::latest()->take(4)->unsearchable();


    }
}
