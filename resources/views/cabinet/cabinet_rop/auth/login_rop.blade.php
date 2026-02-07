@extends('layouts.layout')
@section('title', config('site.constants.enter_for_rop'))
@section('description', config('site.constants.enter_for_rop'))
@section('keywords', config('site.constants.enter_for_rop'))
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
                                <p class="_subtitle">{{ config('site.constants.rop_text') }}</p>
                            </div>
                            @include('cabinet.cabinet_rop.auth.forms.f-login_rop')
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection

