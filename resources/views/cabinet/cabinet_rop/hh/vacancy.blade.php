@extends('layouts.layout')
<x-seo.meta
    :title="$item->title"
    :description="$item->title"
    :keywords="$item->title"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render($breadcrumb, $item) }}
            </div>
            <x-cabinet.title
                :title="config('site.constants.head_sales_department')"
                :subtitle="$r->username"
            />

            <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>
                </div>

                <div class="block_content__right">
                    <div class="hh_item">
                        <div class="hh__flex">
                            @php $img = ($item->logo) ?: ($item->img ?? ''); @endphp
                            @if($img)
                                <div class="avatar">
                                    <img src="{{ asset(intervention('186x186', $img, 'hh/intervention')) }}" alt="{{ $item->title }}"/>
                                </div>
                            @endif

                            <div class="content">
                                <h1 class="h1">{{ $item->title }}</h1>

                                @if($item->subtitle)
                                    <div class="subtitle">{{ $item->subtitle }}</div>
                                @endif

                                @if($item->archive === \App\Enums\HH\VacancyArchiveEnum::ARCHIVE->value)
                                    <div class="hh__not_published">В архиве · Не опубликована</div>
                                @elseif(!$item->published)
                                    <div class="hh__not_published">Не опубликована</div>
                                @else
                                    <div class="hh__not_published hh__published">Опубликована</div>
                                @endif

                                <div class="price">{{ price($item->price) }} {{ config('currency.currency.KZT') }}</div>

                                @if($item->company)
                                    <div class="company">{{ $item->company }}</div>
                                @endif

                                <hr>

                                @if($item->post)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Должность</h2>
                                        <div class="hh__text">{{ $item->post }}</div>
                                    </div>
                                @endif

                                @if($item->experience)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Опыт работы</h2>
                                        <div class="hh__text desc">{{ $item->experience->title }}</div>
                                    </div>
                                @endif

                                @if($item->city)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Город</h2>
                                        <div class="hh__text">{{ $item->city->title }}</div>
                                    </div>
                                @endif

                                @if($item->desc)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Описание</h2>
                                        <div class="hh__text desc">{!! $item->desc !!}</div>
                                    </div>
                                @endif

                                @if($item->must)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Требования</h2>
                                        <div class="hh__text desc">{!! $item->must !!}</div>
                                    </div>
                                @endif

                                @if($item->conditions)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Условия работы</h2>
                                        <div class="hh__text desc">{!! $item->conditions !!}</div>
                                    </div>
                                @endif

                                @if($item->address)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Адрес</h2>
                                        <div class="hh__text">{{ $item->address }}</div>
                                    </div>
                                @endif

                                @if($item->user)
                                    <div class="hh_box">
                                        <h2 class="h2 pad_b9">Пользователь</h2>
                                        <div class="hh__text">
                                            <a href="{{ route('rop_update_user', $item->user->id) }}" target="_blank">{{ $item->user->username }}</a>
                                        </div>
                                    </div>
                                @endif

                                <div class="cu_row_50 hh__actions">
                                    <div class="cu__col">
                                        <form action="{{ route('rop_hh_vacancy_publish', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-big btn-green" {{ $item->published ? 'disabled' : '' }}><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>Опубликовать</button>
                                        </form>
                                    </div>
                                    <div class="cu__col">
                                        <form action="{{ route('rop_hh_vacancy_unpublish', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-big btn-red" {{ !$item->published ? 'disabled' : '' }}><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" /></svg>Заблокировать</button>
                                        </form>
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
