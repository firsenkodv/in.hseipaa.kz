@extends('layouts.layout')
<x-seo.meta
    title="Восстановление пароля"
    description="Восстановление пароля"
    keywords="Восстановление пароля"
/>
@section('content')

    <main class="auth app_form_loader">

        <section>
            <div class="block block_content">

                <div class="window_white_wrap">
                    <div class="window_white">
                        <x-form.form-loader />
                        <div class="window_white__padding">
                            <div class="window_white__title">
                                <h1 class="h1">Восстановление пароля</h1>
                                <p class="_subtitle">Введите новый пароль</p>
                            </div>

                            <x-form action="{{ route('password_handle') }}">
                                <input type="hidden" value="{{ $token }}" name="token"/>
                                <x-form.form-input
                                    name="email"
                                    type="email"
                                    label="Email"
                                    value="{{ old('email') ?: $email }}"
                                    required="{{ true }}"
                                    autofocus="{{ true }}"
                                />
                                <x-form.form-input
                                    name="password"
                                    type="password"
                                    label="Пароль"
                                    value=""
                                    required="{{ true }}"
                                />
                                <x-form.form-input
                                    name="password_confirmation"
                                    type="password"
                                    label="Повторите пароль"
                                    required="{{ true }}"
                                />

                                <div class="input-button">
                                    <x-form.form-button class="w_100_important" type="submit">Восстановить пароль</x-form.form-button>
                                </div>
                                <div class="auth_links">
                                    <div class="auth_link"><a href="{{ route('login') }}">Вспомнил пароль</a></div>
                                    <div class="auth_link"><a href="{{ route('sign_up') }}">Регистрация</a></div>
                                </div>

                            </x-form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
