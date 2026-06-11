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
                {{ Breadcrumbs::render('admin_users') }}
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
                    <x-cabinet-admin.user.user-list
                        :items="$users"
                        :search="isset($search) ? $search : ''"
                        :roles="isset($roles) ? $roles : []"
                    />
                </div>

            </div>

        </div>
    </section>
@endsection
