@extends('layouts.layout')
<x-seo.meta
    title="Пользователь {{ $user->username }}"
    description="Пользователь {{ $user->username }}"
    keywords="Пользователь {{ $user->username }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('admin_user', $user) }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.admin')"
                :subtitle="$a->username"
            />

            <x-cabinet-admin.menu.cabinet-admin-top-menu :user="$a"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-admin.cabinet-admin-personal-data-relation :user="$a"/>
                </div>

                <div class="block_content__right">
                    <x-cabinet-admin.user.user-card :user="$user"/>
                    <div id="js-user-contracts">
                        <x-cabinet-admin.user.user-contracts :contracts="$contracts" :editable="true"/>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
