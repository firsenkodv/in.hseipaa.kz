@extends('layouts.layout')
<x-seo.meta
    title="Архив резюме"
    description="Архив резюме"
    keywords="Архив резюме"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('my_resume_archive_show', $item) }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Архив резюме"
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
                                    <div class="hh__not_published">В архиве · Не опубликовано</div>

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
                                    <div class="hh__text desc">{!! $item->desc !!}</div>
                                </div>
                                <div class="hh_box">
                                    <h2 class="h2">Навыки и требования</h2>
                                    <div class="hh__text desc">{!! $item->must !!}</div>
                                </div>
                                <div class="hh_box">
                                    <h2 class="h2">Условия</h2>
                                    <div class="hh__text desc">{!! $item->conditions !!}</div>
                                </div>

                                <div class="cu_row_50 hh__actions">
                                    <div class="cu__col">
                                        <form action="{{ route('my_resume_restore', $item->id) }}" method="POST" id="restore-resume-form">
                                            @csrf
                                            <button type="submit" class="btn btn-big btn-green"><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" /></svg>Восстановить</button>
                                        </form>
                                    </div>
                                    <div class="cu__col">
                                        <form action="{{ route('my_resume_delete', $item->id) }}" method="POST" id="delete-resume-form">
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
    document.getElementById('restore-resume-form').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Восстановить резюме из архива?')) {
            this.submit();
        }
    });

    document.getElementById('delete-resume-form').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Вы уверены, что хотите удалить это резюме? Это действие необратимо.')) {
            this.submit();
        }
    });
</script>
@endpush
