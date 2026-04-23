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
                {{ Breadcrumbs::render('my_vacancy_archive_show', $item) }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Архив вакансий"
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
                                <div class="hh__not_published">В архиве · Не опубликована</div>

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

                                <div class="cu_row_50 hh__actions">
                                    <div class="cu__col">
                                        <form action="{{ route('my_vacancy_restore', $item->id) }}" method="POST" id="restore-vacancy-form">
                                            @csrf
                                            <button type="submit" class="btn btn-big btn-green"><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" /></svg>Восстановить</button>
                                        </form>
                                    </div>
                                    <div class="cu__col">
                                        <form action="{{ route('my_vacancy_delete', $item->id) }}" method="POST" id="delete-vacancy-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-big btn-red"><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>Удалить</button>
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

@push('scripts')
<script>
    document.getElementById('restore-vacancy-form').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Восстановить вакансию из архива?')) {
            this.submit();
        }
    });

    document.getElementById('delete-vacancy-form').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Вы уверены, что хотите удалить эту вакансию? Это действие необратимо.')) {
            this.submit();
        }
    });
</script>
@endpush
