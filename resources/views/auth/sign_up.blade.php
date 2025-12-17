@extends('layouts.layout')
<x-seo.meta
    title="Вход в личный кабинет"
    description="Вход в личный кабинет"
    keywords="Вход в личный кабинет"
/>
@section('content')
    <main class="auth sign_up app_form_loader">

        <section>
            <div class="block block_content ">

                {{--
                     Вариант для выноса заголовков
                     <div class="block_content__title">
                               <h1 class="h1">Регистрация</h1>
                               <p class="_subtitle">Для работы в личном кабинете требуется регистрация</p>
                           </div>
                           --}}
                <div class="window_white_wrap">
                    <div class="window_white">
                        <x-form.form-loader/>

                        <div class="window_white__padding">
                            <div class="window_white__title">
                                <h1 class="h1">Регистрация</h1>
                                <p class="_subtitle">Для работы в личном кабинете требуется регистрация</p>
                            </div>
                            <x-form action="{{ route('handle_sign_up') }}">

                                <x-form.form-radio2-component/>

                                <x-form.form-input
                                    name="username"
                                    type="text"
                                    label="Имя"
                                    value="{{ old('username')?:'' }}"
                                    required="{{ true }}"
                                    autofocus="{{ true }}"
                                />
                                <x-form.form-input
                                    name="email"
                                    type="text"
                                    label="Email"
                                    value="{{ old('username')?:'' }}"
                                    required="{{ true }}"
                                />
                                <x-form.form-input
                                    name="password"
                                    type="password"
                                    label="Пароль"
                                    value="{{ old('password')?:'' }}"
                                    required="{{ true }}"
                                />

                                <x-form.form-input
                                    name="password_confirmation"
                                    type="password"
                                    label="Повторите пароль"
                                    required="{{ true }}"
                                />


                                <div class="input-button ">
                                    <x-form.form-button class="w_100_important" type="submit">Зарегистрироваться
                                    </x-form.form-button>
                                </div>
                                <div class="auth_links">
                                    <div class="auth_link"><a href="{{ route('forgot') }}">Восстановить пароль</a></div>
                                    <div class="auth_link"><a href="{{ route('login') }}">Вход</a></div>
                                </div>
                            </x-form>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection


