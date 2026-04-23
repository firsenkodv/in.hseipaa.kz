@extends('layouts.layout')
<x-seo.meta
    title="Архив вакансий"
    description="Архив вакансий"
    keywords="Архив вакансий"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('my_vacancy_archive') }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Архив вакансий"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex">

                <div class="block_content__left">
                    <x-menu.hh-menu-component :my="true"/>
                    <x-h-h.vacancy.user-vacancy-selection-component :user="$user"/>
                </div>

                <div class="block_content__right">
                    <div class="block_content__items">
                        @forelse($items as $item)
                            <div class="teaser">
                                <div class="teaser__flex">
                                    <div class="left">
                                        <h2><a href="{{ route('my_vacancy_archive_show', $item->id) }}">{{ $item->title }}</a></h2>
                                        @if($item->subtitle)
                                            <div class="subtitle">{{ $item->subtitle }}</div>
                                        @endif
                                        <div class="hh__not_published">В архиве · Не опубликована</div>
                                        <div class="price">{{ price($item->price) }} {{ config('currency.currency.KZT') }}</div>
                                        @if($item->company)
                                            <div class="company">{{ $item->company }}</div>
                                        @endif
                                    </div>
                                    <div class="right">
                                        @php
                                            $img = ($item->logo)?:($item->img??'');
                                        @endphp
                                        @if($img)
                                            <a href="{{ route('my_vacancy_archive_show', $item->id) }}"><img
                                                    src="{{ asset(intervention('80x80', $img, 'hh/intervention')) }}"
                                                    alt="{{ $item->title }}"/></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="teaser__short_desc">
                                    <a href="{{ route('my_vacancy_archive_show', $item->id) }}" class="btn btn-middle">Посмотреть</a>
                                </div>
                            </div>
                        @empty
                            <div class="Not_yet">Архив пуст</div>
                        @endforelse
                    </div>

                    {{ $items->links('pagination::default') }}
                </div>

            </div>

        </div>
    </section>
@endsection
