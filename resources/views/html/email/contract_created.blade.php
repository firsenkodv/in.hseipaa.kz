@extends('html.email.layouts.layout_default_mail')
@section('title', 'Договор на обучение')
@if(!empty($contract['organization_logo']))
@section('email_logo')
@php [$w, $h] = $contract['organization_logo_size']; @endphp
<img src="{{ $contract['organization_logo'] }}"
     alt="{{ $contract['organization_label'] ?? '' }}"
     width="{{ $w }}" height="{{ $h }}"
     style="width:{{ $w }}px;height:{{ $h }}px;left:-10px;position:relative;background:#ffffff;border-radius:1px;padding:5px 20px 5px 0;">
@endsection
@endif
@section('description')
    Для вас оформлен договор на обучение.
@endsection
@section('content')
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#444;">
        Здравствуйте, <strong>{{ $contract['fio'] }}</strong>!
    </p>
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:15px;line-height:22px;color:#444;">
        Администратор оформил для вас договор на обучение. Ниже представлены данные договора:
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;border-collapse:collapse;">
        @if(!empty($contract['contract_number']))
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;width:160px;">№ договора:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $contract['contract_number'] }}</strong></td>
        </tr>
        @endif
        @if(!empty($contract['organization_label']))
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Организация:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;">{{ $contract['organization_label'] }}</td>
        </tr>
        @endif
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;width:160px;">ФИО:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $contract['fio'] }}</strong></td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Email:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;">{{ $contract['email'] }}</td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Телефон:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;">{{ $contract['phone'] }}</td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Дисциплина:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ $contract['training_id'] }}</strong></td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Период обучения:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;">{{ $contract['date_from'] }} — {{ $contract['date_to'] }}</td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;border-bottom:1px solid #eee;">Стоимость:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;border-bottom:1px solid #eee;"><strong>{{ number_format((float)$contract['price'], 0, '.', ' ') }}&nbsp;{{ $contract['currency'] }}</strong></td>
        </tr>
        <tr>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#666;padding:8px 0;">Количество часов:</td>
            <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#282828;padding:8px 0;">{{ $contract['hours'] }} ч.</td>
        </tr>
    </table>

    <p style="text-align:center;margin:24px 0 12px;">
        <a href="{{ $contract['public_url'] }}"
           target="_blank"
           style="background-color:#095C9A;border-radius:4px;color:#ffffff;display:inline-block;font-family:Arial,Helvetica,sans-serif;font-size:15px;font-weight:bold;line-height:48px;text-align:center;text-decoration:none;padding:0 32px;">
            Открыть и подписать договор &rarr;
        </a>
    </p>
    <p style="text-align:center;margin:0 0 24px;">
        <a href="{{ config('app.url') }}/login"
           target="_blank"
           style="color:#095C9A;font-family:Arial,Helvetica,sans-serif;font-size:13px;text-decoration:underline;">
            Войти в личный кабинет
        </a>
    </p>

    @if(!empty($contract['manager_name']))
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;background-color:#fffaf0;border-left:3px solid #f0b429;padding:12px 16px;border-radius:4px;">
        Если у вас возникли вопросы, свяжитесь с вашим менеджером:<br>
        <strong>{{ $contract['manager_name'] }}</strong>
        @if(!empty($contract['manager_email']))
            &mdash; <a href="mailto:{{ $contract['manager_email'] }}" style="color:#095C9A;">{{ $contract['manager_email'] }}</a>
        @endif
        @if(!empty($contract['manager_phone']))
            &mdash; {{ $contract['manager_phone'] }}
        @endif
    </p>
    @else
    <p style="font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:20px;color:#5a4a1f;background-color:#fffaf0;border-left:3px solid #f0b429;padding:12px 16px;border-radius:4px;">
        Если у вас возникли вопросы — войдите в личный кабинет и напишите вашему менеджеру.
    </p>
    @endif
@endsection
