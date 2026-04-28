@extends('html.email.layouts.layout_default_mail')
@section('title', 'Восстановление пароля')
@section('description')
    Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учётной записи.
@endsection
@section('content')
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#444;">
        Нажмите на кнопку ниже, чтобы задать новый пароль:
    </p>

    <p style="text-align:center;margin:24px 0;">
        <a href="{{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ urlencode($user['email']) }}"
           target="_blank"
           style="background-color:#1a73e8;border-radius:4px;color:#ffffff;display:inline-block;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;line-height:48px;text-align:center;text-decoration:none;padding:0 32px;">
            Сбросить пароль &rarr;
        </a>
    </p>

    <p style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:20px;color:#8a8a92;">
        Или скопируйте ссылку в браузер:<br>
        <a href="{{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ urlencode($user['email']) }}"
           target="_blank"
           style="color:#1a73e8;word-break:break-all;">
            {{ config('app.url') }}/reset-password/{{ $user['token'] }}/?email={{ urlencode($user['email']) }}
        </a>
    </p>

    <p style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;background-color:#fffaf0;border-left:3px solid #f0b429;padding:12px 16px;border-radius:4px;">
        Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.
    </p>
@endsection
