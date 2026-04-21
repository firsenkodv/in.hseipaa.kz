@extends('layouts.layout')
<x-seo.meta
    title="Мои резюме"
    description="Мои резюме"
    keywords="Мои резюме"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('my_resume', $item) }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Мои резюме"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-menu.hh-menu-component :my="true"/>
                    <x-h-h.resume.user-resume-selection-component :user="$user"/>
                    <x-h-h.vacancy.contact-component :user="$user" :item="$item" :resume="true"/>
                </div>

                <div class="block_content__right">
                    <div class="hh_item">

                        <div class="cabinet_user_personal__flex">

                            <div class="cabinet_user_personal__left">
                                <div class="avatar_avatar-user">
                                    @php
                                        $img = ($user->avatar)?:($item->img??'');
                                    @endphp
                                    <label class="cu__avatar"
                                           style="background-image: url({{ asset(intervention('186x186', $img, 'hh/intervention')) }}"
                                           alt="{{ $item->title }})">
                                    </label>
                                </div>
                            </div>

                            <div class="cabinet_user_personal__right">

                                <div class="cu_username">
                                    <h1 class="h1">{{ $item->title }}</h1>
                                    @if($item->subtitle)
                                        <div class="subtitle">{{ $item->subtitle }}</div>
                                    @endif
                                    @if(!$item->published)
                                        <div class="hh__not_published">Не опубликовано</div>
                                    @endif

                                    @if($user->date_birthday)
                                        <p class="_subtitle">{{ birthdate($user->date_birthday) }}</p>
                                    @endif

                                    <div class="pad_t10">{{ $user->username }}</div>
                                </div>

                                <div class="cu__personal_wrap">

                                    <div class="cabinet_user_personal__flex">
                                        <div class="cabinet_user_personal__left">
                                            <div class="cu__personal_label"><span>Пол:</span></div>
                                        </div>
                                        <div class="cabinet_user_personal__right">
                                            <div class="cu__personal_option">
                                                {{ isset($user->UserSex)?$user->UserSex->title:'—' }}
                                            </div>
                                        </div>
                                    </div>

                                    @if($user->hasTarif)

                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Электронная почта:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">
                                                    {{ ($user->email)??'—' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Телефон:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">
                                                    {{ ($user->phone)?phone($user->phone):'—' }}
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                                    <div class="cabinet_user_personal__flex">
                                        <div class="cabinet_user_personal__left">
                                            <div class="cu__personal_label"><span>Опыт:</span></div>
                                        </div>
                                        <div class="cabinet_user_personal__right">
                                            <div class="cu__personal_option">
                                                {{ ($item->experience)?$item->experience->title:'—' }}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <br>
                                <div class="hh_box">
                                    <h2 class="h2">Описание</h2>
                                    <div class="hh__text desc">
                                        {!! $item->desc !!}
                                    </div>
                                </div>
                                <div class="hh_box">
                                    <h2 class="h2">Навыки и требования</h2>
                                    <div class="hh__text desc">
                                        {!! $item->must !!}
                                    </div>
                                </div>
                                <div class="hh_box">
                                    <h2 class="h2">Условия</h2>
                                    <div class="hh__text desc">
                                        {!! $item->conditions !!}
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
