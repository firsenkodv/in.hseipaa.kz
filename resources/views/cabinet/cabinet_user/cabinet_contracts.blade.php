@extends('layouts.layout')
<x-seo.meta
    title="Мои договоры"
    description="Мои договоры"
    keywords="Мои договоры"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_contracts') }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title)) ? $user->UserHuman->title : ''"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-user.cabinet-user-personal-data-relation :user="$user"/>
                </div>

                <div class="block_content__right user_contracts">
                    @if($contracts->isNotEmpty())
                        <x-cabinet-admin.user.user-contracts :contracts="$contracts" :signable="true"/>
                    @else
                        <div class="form_title">
                            <div class="form_title__h1">Договоры</div>
                            <div class="form_title__h2">У вас пока нет оформленных договоров</div>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </section>
@endsection
