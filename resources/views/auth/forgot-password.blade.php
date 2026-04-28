@extends('layouts.layout')
<x-seo.meta
    title="Забыли пароль"
    description="Восстановление пароля"
    keywords="Забыли пароль"
/>
@section('content')
    <main class="auth app_form_loader">

        <section>
            <div class="block block_content">

                <div class="window_white_wrap">
                    <div class="window_white">
                        @if(!$forgot)
                            <div class="window_white__padding">
                                <div class="window_white__title">
                                    <h1 class="h1">Восстановление пароля</h1>
                                    <p class="_subtitle">Введите свой email, указанный при регистрации</p>
                                </div>

                                <x-form action="{{ route('handel_forgot') }}">
                                    <x-form.form-input
                                        name="email"
                                        type="email"
                                        label="Email"
                                        value="{{ old('email') ?: '' }}"
                                        required="{{ true }}"
                                        autofocus="{{ true }}"
                                    />

                                    <div class="input-button">
                                        <x-form.form-button class="w_100_important" type="submit">Отправить</x-form.form-button>
                                    </div>
                                    <div class="auth_links">
                                        <div class="auth_link"><a href="{{ route('login') }}">Вспомнил пароль</a></div>
                                        <div class="auth_link"><a href="{{ route('sign_up') }}">Регистрация</a></div>
                                    </div>
                                </x-form>

                            </div>
                        @else
                            <div class="window_white__padding">
                                <div class="window_white__title">
                                    <h1 class="h1">Письмо отправлено</h1>
                                    <p class="_subtitle">Ссылка для восстановления пароля отправлена на ваш email. Проверьте почту.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection
