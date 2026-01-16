@extends('layouts.layout')
<x-seo.meta
    title="Услуги"
    description="Услуги"
    keywords="Услуги"
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

                    <x-cabinet-user.cabinet-user-personal-data-relation :user="$user"/>

                </div>
                <div class="block_temp1">

                    <div class="block_temp1__flex">
                        <div class="block_temp1__left">
                            <div class="menu_left-menu-component">
                                <div class="left_menu">
                                    <ul class="left_menu__ul">
                                        <li class=" ">
                                            <a href="https://in-hseipaa.test/service-services/yuridicheskoe-soprovozhdenie"><span>Юридическое сопровождение</span></a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                        <div class="block_temp1__right">

                            <div class="other_right">
                                <div class="temp_title">
                                    <h2>Юридическое сопровождение</h2>
                                </div>
                                <div class="temp_desc">
                                    <p>У вас будет юрист который будет сопровождать вас во время подписки на услугу. Для защиты в суде, составления иска и т.п.</p>
                                </div>
                                <div class="temp_price">
                                    6 000 ₸ / в мес.
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>


        </div>
    </section>
@endsection

