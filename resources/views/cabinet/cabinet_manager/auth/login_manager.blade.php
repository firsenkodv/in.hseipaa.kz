@extends('layouts.layout')
@section('title', config('site.constants.enter_for_manager'))
@section('description', config('site.constants.enter_for_manager'))
@section('keywords', config('site.constants.enter_for_manager'))
@section('content')
    <main class="auth app_form_loader">
        <section>
            <div class="block block_content ">
                <div class="window_white_wrap">
                    <div class="window_white">
                        <x-form.form-loader />
                        <div class="window_white__padding">
                            <div class="window_white__title">
                                <!--Авторизация-->
                                <!--Вход для Manager, управление менеджерами-->
                                <h1 class="h1">{{ config('site.constants.authorization') }}</h1>
                                <p class="_subtitle">{{ config('site.constants.manager_text') }}</p>
                            </div>
                            @include('cabinet.cabinet_manager.auth.forms.f-login_manager')
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection





