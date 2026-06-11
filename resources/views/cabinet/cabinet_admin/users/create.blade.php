@extends('layouts.layout')
<x-seo.meta
    title="Создать пользователя"
    description="Создать пользователя"
    keywords="Создать пользователя"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('admin_user_create') }}
            </div>

            <x-cabinet.title
                title="Создать пользователя"
                :subtitle="$a->username"
            />

            <x-cabinet-admin.menu.cabinet-admin-top-menu :user="$a"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-admin.cabinet-admin-personal-data-relation :user="$a"/>
                </div>

                <div class="block_content__right">

                    <x-form.form
                        title="Новый пользователь"
                        subtitle="Данные для входа будут отправлены пользователю на email"
                        :action="route('admin_user_create_handle')"
                        method="POST"
                    >

                        <div class="text_input">
                            <x-form.form-input
                                label="Имя"
                                type="text"
                                name="username"
                                :required="true"
                                :value="old('username')"
                            />
                            @error('username')
                                <span class="form_error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text_input">
                            <x-form.form-input
                                label="Компания"
                                type="text"
                                name="company"
                                :required="false"
                                :value="old('company')"
                            />
                            @error('company')
                                <span class="form_error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text_input">
                            <x-form.form-input
                                label="Email"
                                type="email"
                                name="email"
                                :required="true"
                                :value="old('email')"
                            />
                            @error('email')
                                <span class="form_error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text_input">
                            <x-form.form-input
                                label="Пароль"
                                type="password"
                                name="password"
                                :required="true"
                                value=""
                            />
                            @error('password')
                                <span class="form_error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text_input">
                            <x-form.form-input
                                label="Повторите пароль"
                                type="password"
                                name="password_confirmation"
                                :required="true"
                                value=""
                            />
                        </div>

                        <div class="pageLogin__slotButtons slotButtons">
                            <div class="slotButtons__flex">
                                <div class="slotButtons__right">
                                    <x-form.form-button class="w_100_important" type="submit">
                                        Создать пользователя
                                    </x-form.form-button>
                                </div>
                            </div>
                        </div>

                    </x-form.form>

                </div>

            </div>

        </div>
    </section>
@endsection
