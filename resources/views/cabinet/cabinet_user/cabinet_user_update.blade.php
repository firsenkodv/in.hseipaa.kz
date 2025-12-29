@extends('layouts.layout')
<x-seo.meta
        title="Кабинет Пользователя"
        description="Кабинет Пользователя"
        keywords="Кабинет Пользователя"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_user') }}
            </div>
            <div class="block_content__title"><h1 class="h1">Мой профиль</h1>
                @if($user->UserHuman)
                    <p class="_subtitle">{{ $user->UserHuman->title }}</p>
                @endif
            </div>

            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">
                <div class="block_content__left">
                    <x-cabinet-user.cabinet-user-personal-data-relation :user="$user" :relation="false"/>

                </div>
                <div class="block_content__right">
                    <x-cabinet-user.update.cabinet-user-update :user="$user" />
                </div>
            </div>


        </div>
    </section>
@endsection

