<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * @test
     * 注册时触发认证邮件
     */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();
        $this->post(route('register'),[
            'name' => 'NoNo1',
            'email' => 'NoNo1@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /**
     * @test
     * 用户点击认证邮件能成功认证
     */
    public function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post(route('register'), [
           'name' => 'NoNo1',
           'email' => 'NoNo1@example.com',
           'password' => '12345678',
           'password_confirmation' => '12345678'
        ])->assertStatus(302);

        $user = User::where('name', 'NoNo1')->first();
        // 未认证
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        // 用路由命名代替 url
        $this->get(route('register.confirm',['token' => $user->confirmation_token]))
            ->assertRedirect(route('threads'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->confirmed);
            $this->assertNull($user->confirmation_token);
        });
    }
}
