<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{

    /**
     * @test
     * 检测内容是否违规
     */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();
        $this->assertFalse($spam->detect('Innocent reply here.'));
        $this->expectException('Exception');
        $spam->detect('something forbidden');
    }

    /**
     * @test
     * 检测重复输入
     */
    public function it_checks_for_any_being_held_down()
    {
        $spam = new Spam();
        $this->expectException('Exception');
        $spam->detect('Hello word aaaaaaaaaa');
    }

}
