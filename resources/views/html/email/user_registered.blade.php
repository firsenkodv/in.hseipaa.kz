@extends('html.email.layouts.layout_default_mail')
@section('title', 'Добро пожаловать!')
@section('description')
    Ваш личный кабинет на портале бухгалтеров Казахстана успешно зарегистрирован.
@endsection
@section('content')
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#444;">
        Здравствуйте, <strong>{{ $user['username'] }}</strong>!
    </p>
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#444;">
        Ваш аккаунт создан администратором. Ниже ваши данные для входа:
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;border-collapse:collapse;">
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;width:140px;">Email:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $user['email'] }}</strong></td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Пароль:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $user['password'] }}</strong></td>
        </tr>
    </table>

    <p style="text-align:center;margin:24px 0;">
        <a href="{{ config('app.url') }}/login"
           target="_blank"
           style="background-color:#095C9A;border-radius:4px;color:#ffffff;display:inline-block;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;line-height:48px;text-align:center;text-decoration:none;padding:0 32px;">
            Войти в личный кабинет &rarr;
        </a>
    </p>

    <p style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;background-color:#fffaf0;border-left:3px solid #f0b429;padding:12px 16px;border-radius:4px;">
        Рекомендуем сменить пароль после первого входа.
    </p>
@endsection
