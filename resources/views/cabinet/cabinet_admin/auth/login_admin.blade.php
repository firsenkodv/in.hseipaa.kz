@extends('layouts.layout')
@section('title', config('site.constants.admin'))
@section('description', config('site.constants.admin'))
@section('keywords', config('site.constants.admin'))
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
                                <!--Вход для РОП, управление менеджерами-->
                                <h1 class="h1">{{ config('site.constants.authorization') }}</h1>
                                <p class="_subtitle">{{ config('site.constants.admin_text') }}</p>
                            </div>
                            @include('cabinet.cabinet_admin.auth.forms.f-login_admin')
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

