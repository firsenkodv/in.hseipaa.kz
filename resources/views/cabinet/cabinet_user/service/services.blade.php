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
                        @if($items->count())


                            <div class="block_temp1__flex">
                                <div class="block_temp1__left">
                                    <div class="menu_left-menu-component">
                                        <div class="left_menu">
                                            <ul class="left_menu__ul">
                                                <li class=" ">
                                                    <a href=""><span>х з</span></a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>

                                </div>
                                <div class="block_temp1__right temp_other">
                                    @foreach($items as $item)
                                    <div class="other_right desc">
                                        <div class="temp_title">
                                            <h2>{{ $item->temp_title }}</h2>
                                        </div>
                                        <div class="temp_desc">
                                            {!!  $item->temp_desc !!}
                                        </div>
                                        <div class="temp_price">
                                            {{ $item->temp_price }}
                                        </div>
                                        <div class="temp_button pad_b40">
                                            <a href="#" class="btn btn-middle open-fancybox" data-form="subscription_me">Заказать услугу</a>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>
                            </div>
                        @endif
                    </div>

            </div>


        </div>
    </section>
@endsection

