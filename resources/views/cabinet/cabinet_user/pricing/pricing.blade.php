@extends('layouts.layout')
<x-seo.meta
    title="Тарифный план"
    description="Тарифный план"
    keywords="Тарифный план"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_user') }}
            </div>
            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
            />

            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">
                <div class="block_content__left">

                    <x-cabinet-user.cabinet-user-personal-data-relation :user="$user"/>


                </div>
                <div class="block_content__right">

                    <x-content.content-tarif-component />


                </div>
            </div>


        </div>
    </section>
@endsection


