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
                {{ Breadcrumbs::render('my_resumes') }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Мои резюме"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex">

                <div class="block_content__left">
                    <x-menu.hh-menu-component :my="true"/>
                    <x-h-h.resume.user-resume-selection-component :user="$user"  />
                </div>

                <div class="block_content__right">
                    <div class="block_content__items">
                        @forelse($items as $item)
                            <div class="teaser">
                                <div class="teaser__flex">
                                    <div class="r_left">
                                        @php
                                            $img = ($user->avatar)?:($item->img??($item->logo?:''));
                                        @endphp
                                        @if($img)
                                            <a href="{{ route('my_resume', $item->id) }}"><img
                                                    src="{{ asset(intervention('80x80', $img, 'hh/intervention')) }}"
                                                    alt="{{ $item->title }}"/></a>
                                        @endif
                                    </div>
                                    <div class="r_center">
                                        <h2><a href="{{ route('my_resume', $item->id) }}">{{ $item->title }}</a></h2>
                                        @if($item->subtitle)
                                            <div class="subtitle">{{ $item->subtitle }}</div>
                                        @else
                                            <div class="subtitle">&mdash;</div>
                                        @endif
                                        @if($item->experience)
                                            <div class="hh__text desc">Опыт работы &mdash; {{ $item->experience->title }}</div>
                                        @endif
                                    </div>
                                    <div class="r_right">
                                        <div class="price">{{ price($item->price) }} {{ config('currency.currency.KZT') }}</div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="Not_yet">Резюме не найдены</div>
                        @endforelse
                    </div>

                    {{ $items->links('pagination::default') }}
                </div>

            </div>

        </div>
    </section>
@endsection
