@extends('layouts.layout')
<x-seo.meta
    title="Список пользователей"
    description="Список пользователей"
    keywords="Список пользователей"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('manager_users') }}
            </div>
            <x-cabinet.title
                :title="config('site.constants.manager')"
                :subtitle="$m->username"
            />

            <x-cabinet-manager.menu.cabinet-manager-top-menu :user="$m"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                 {{--   <x-cabinet.main-manager :item="$user->Manager"/>--}}
                    <x-cabinet-manager.cabinet-manager-personal-data-relation :user="$m"/>
                </div>

                <div class="block_content__right">
                    <x-cabinet-manager.user.user-list
                        :items="$users"
                        :markDelete="isset($markDelete) ? $markDelete : false"
                    />
                </div>

            </div>

        </div>
    </section>
@endsection
