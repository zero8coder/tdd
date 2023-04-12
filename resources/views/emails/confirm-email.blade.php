@component('mail::message')
# 发送邮件

确认邮箱

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
认证邮箱
@endcomponent

谢谢,<br>
{{ config('app.name') }}
@endcomponent
