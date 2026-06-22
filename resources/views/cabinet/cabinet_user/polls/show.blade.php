@extends('layouts.layout')
<x-seo.meta
    title="{{ $poll->title }}"
    description="{{ $poll->title }}"
    keywords="{{ $poll->title }}"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_poll', $poll) }}
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
                        <div class="form_title__h1">{{ $poll->title }}</div>
                        @if($response)
                            <div class="form_title__h2">Вы уже ответили на этот опрос. Ниже приведены ваши ответы.</div>
                        @elseif($isExpired)
                            <div class="form_title__h2 poll-expired-notice">Срок проведения опроса истёк. Вы не успели принять участие.</div>
                        @else
                            <div class="form_title__h2">Пожалуйста, выберите ответ на каждый вопрос. Все поля обязательны.</div>
                        @endif
                    </div>

                    @if($poll->expires_at)
                        <div class="poll-deadline">
                            Опрос проходит до: <strong>{{ $poll->expires_at->format('d.m.Y') }}</strong>
                        </div>
                    @endif

                    @php $questions = $poll->questions ?? []; @endphp

                    @if(count($questions) === 0)

                        <p class="grey">В этом опросе пока нет вопросов.</p>

                    @elseif($response)

                        {{-- Режим просмотра: сохранённые ответы --}}
                        <div class="poll-answers">
                            @foreach($response->answers as $answer)
                                <div class="poll-answers__item cabinet_radius12_fff">
                                    <div class="poll-answers__question">
                                        {{ $answer->question_index + 1 }}. {{ $answer->question_text }}
                                    </div>
                                    <div class="poll-answers__answer">{{ $answer->answer }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="input-button" style="margin-top: 20px;">
                            <a href="{{ route('cabinet_polls') }}" class="btn btn-big">← Назад к списку</a>
                        </div>

                    @elseif($isExpired)

                        {{-- Опрос истёк, пользователь не ответил --}}
                        <div class="input-button" style="margin-top: 20px;">
                            <a href="{{ route('cabinet_polls') }}" class="btn btn-big">← Назад к списку</a>
                        </div>

                    @else

                        {{-- Режим прохождения: форма с вариантами ответа --}}
                        <form action="{{ route('cabinet_poll_submit', $poll->id) }}" method="POST">
                            @csrf

                            @foreach($questions as $index => $q)
                                @php
                                    $options    = collect($q['options'] ?? [])->pluck('option')->filter()->values();
                                    $fieldName  = 'answers[' . $index . ']';
                                    $errorKey   = 'answers.' . $index;
                                    $oldValue   = old('answers.' . $index, '');
                                    $optionsArr = $options->map(fn($opt) => ['id' => $opt, 'title' => $opt])->values()->toArray();
                                @endphp
                                <div class="poll-question">
                                    <div class="poll-question__text">{{ $index + 1 }}. {{ $q['question'] ?? '' }}</div>

                                    @if($options->isNotEmpty())
                                        <div class="poll-select-wrap">
                                            <x-form.form-select-cabinet
                                                name="— Выберите вариант —"
                                                :selected="$oldValue"
                                                :value="$oldValue"
                                                :options="$optionsArr"
                                                :field_name="$fieldName"
                                                :required="true"
                                            />
                                            @error($errorKey)
                                                <div class="poll-select__error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @else
                                        <p class="grey">Варианты ответа не заданы.</p>
                                    @endif
                                </div>
                            @endforeach

                            <div class="input-button">
                                <div class="cu_row_50">
                                    <div class="cu__col">
                                        <button type="submit" class="btn btn-big btn-green" style="width:100%">Отправить ответы</button>
                                    </div>
                                    <div class="cu__col">
                                        <a href="{{ route('cabinet_polls') }}" class="btn btn-big btn-red" style="width:100%">Отмена</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    @endif

                </div>

            </div>

        </div>
    </section>
@endsection
