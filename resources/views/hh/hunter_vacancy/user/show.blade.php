@extends('layouts.layout')
<x-seo.meta
    title="Мои вакансии"
    description="Мои вакансии"
    keywords="Мои вакансии"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('my_vacancy', $item) }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Мои вакансии"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-menu.hh-menu-component :my="true"/>
                    <x-h-h.vacancy.user-vacancy-selection-component :user="$user"/>
                    <x-h-h.vacancy.contact-component :user="$user" :item="$item"/>
                </div>

                <div class="block_content__right">
                    <div class="hh_item">
                        <div class="hh__flex">
                            @php
                                $img = ($item->logo)?:($item->img??'');
                            @endphp
                            @if($img)
                                <div class="avatar">
                                    <img src="{{ asset(intervention('186x186', $img, 'hh/intervention')) }}" alt="{{ $item->title }}" />
                                </div>
                            @endif
                            <div class="content">
                                <h1 class="h1">{{ $item->title }}</h1>
                                @if($item->subtitle)
                                    <div class="subtitle">{{ $item->subtitle }}</div>
                                @endif

                                <div class="price">{{ price($item->price) }} {{ config('currency.currency.KZT') }}</div>
                                @if($item->company)
                                    <div class="company">{{ $item->company }}</div>
                                @endif
                                <hr>
                                <div class="hh_box">
                                    @if($item->post)
                                        <h2 class="h2 pad_b9">Должность</h2>
                                        <div class="hh__text">{{ $item->post }}</div>
                                    @endif
                                </div>

                                <div class="hh_box">
                                    @if($item->experience)
                                        <h2 class="h2 pad_b9">Опыт работы</h2>
                                        <div class="hh__text desc">{{ $item->experience->title }}</div>
                                    @endif
                                </div>

                                <div class="hh_box">
                                    @if($item->city)
                                        <h2 class="h2 pad_b9">Город</h2>
                                        <div class="hh__text">{{ $item->city->title }}</div>
                                    @endif
                                </div>

                                <div class="hh_box">
                                    @if($item->desc)
                                        <h2 class="h2 pad_b9">Описание</h2>
                                        <div class="hh__text desc">{!! $item->desc !!}</div>
                                    @endif
                                </div>

                                <div class="hh_box">
                                    @if($item->must)
                                        <h2 class="h2 pad_b9">Требования</h2>
                                        <div class="hh__text desc">{!! $item->must !!}</div>
                                    @endif
                                </div>

                                <div class="hh_box">
                                    @if($item->conditions)
                                        <h2 class="h2 pad_b9">Условия работы</h2>
                                        <div class="hh__text desc">{!! $item->conditions !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
