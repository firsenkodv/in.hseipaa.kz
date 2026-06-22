@extends('layouts.layout')
<x-seo.meta
    title="Голосования"
    description="Голосования"
    keywords="Голосования"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_polls') }}
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

                    <div class="form_title">
                        <div class="form_title__h1">Голосования</div>
                        <div class="form_title__h2">Опросы, доступные вам</div>
                    </div>

                    @if($polls->isNotEmpty())
                        <div class="user-polls">
                            @foreach($polls as $poll)
                                @php $answered = isset($respondedIds[$poll->id]); @endphp
                                <div class="user-polls__item">
                                    <div class="user-polls__top">
                                        <div class="user-polls__title">{{ $poll->title }}</div>
                                        @if($answered)
                                            <span class="user-polls__badge user-polls__badge--done">Пройдено</span>
                                        @else
                                            <span class="user-polls__badge user-polls__badge--new">Новое</span>
                                        @endif
                                    </div>
                                    <div class="user-polls__meta">
                                        Вопросов: {{ count($poll->questions ?? []) }}
                                    </div>
                                    <div class="user-polls__actions">
                                        <a href="{{ route('cabinet_poll', $poll->id) }}" class="btn btn-big">
                                            {{ $answered ? 'Посмотреть ответы' : 'Пройти опрос' }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="form_title" style="margin-top: 28px;">
                            <div class="form_title__h2">Для вас пока нет доступных голосований.</div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </section>
@endsection
