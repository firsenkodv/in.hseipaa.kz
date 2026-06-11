@extends('html.email.layouts.layout_default_mail')
@section('title', 'Новый пользователь')
@section('description')
    Администратором зарегистрирован новый пользователь.
@endsection
@section('content')
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#444;">
        В системе создан новый пользователь:
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;border-collapse:collapse;">
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;width:140px;">Имя:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $user['username'] }}</strong></td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Email:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $user['email'] }}</strong></td>
        </tr>
        @if(!empty($user['company']))
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Компания:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;">{{ $user['company'] }}</td>
        </tr>
        @endif
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;">Дата регистрации:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;">{{ now()->format('d.m.Y H:i') }}</td>
        </tr>
    </table>

    <p style="text-align:center;margin:24px 0;">
        <a href="{{ config('app.url') }}/cabinet-administrator/users"
           target="_blank"
           style="background-color:#095C9A;border-radius:4px;color:#ffffff;display:inline-block;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;line-height:48px;text-align:center;text-decoration:none;padding:0 32px;">
            Открыть список пользователей &rarr;
        </a>
    </p>
@endsection
