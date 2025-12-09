@extends('html.email.layouts.layout_default_mail')
@section('title', 'Сообщение с сайта')
@section('description')
    Заполненная форма<br>
@endsection
@section('content')
    @foreach($data as $k => $value)
        <p style="word-wrap: break-word; color: #282828"><b>{{ $k }}:</b>  {{ $value }}<br></p>
    @endforeach
    <hr style=" margin-top: 1rem; margin-bottom: 1.4rem;  border: 0; border-top: 1px solid rgba(0, 0, 0, 0.1);">
@endsection


