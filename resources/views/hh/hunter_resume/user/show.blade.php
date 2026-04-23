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
                                    @if($item->archive === \App\Enums\HH\ResumeArchiveEnum::ARCHIVE->value)
                                        <div class="hh__not_published">В архиве · Не опубликовано</div>
                                    @elseif(!$item->published)
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
                                                {{ isset($user->UserSex) ? $user->UserSex->title : '—' }}
                                            </div>
                                        </div>
                                    </div>

                                    @if($item->post)
                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Должность:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">{{ $item->post }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $displayCity = $item->city->title ?? $user->UserCity?->title ?? null;
                                    @endphp
                                    @if($displayCity)
                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Город:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">{{ $displayCity }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($item->category)
                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Категория:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">{{ $item->category->title }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="cabinet_user_personal__flex">
                                        <div class="cabinet_user_personal__left">
                                            <div class="cu__personal_label"><span>Опыт:</span></div>
                                        </div>
                                        <div class="cabinet_user_personal__right">
                                            <div class="cu__personal_option">
                                                {{ $item->experience ? $item->experience->title : '—' }}
                                            </div>
                                        </div>
                                    </div>

                                    @if($item->price)
                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Желаемая зарплата:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">{{ number_format($item->price, 0, '.', ' ') }} {{ config('currency.currency.KZT') }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($user->hasTarif)

                                        @php
                                            $displayEmail = $item->email ?: ($user->email ?: null);
                                            $displayPhone = $item->phone ?: ($user->phone ?: null);
                                        @endphp

                                        @if($displayEmail)
                                            <div class="cabinet_user_personal__flex">
                                                <div class="cabinet_user_personal__left">
                                                    <div class="cu__personal_label"><span>Электронная почта:</span></div>
                                                </div>
                                                <div class="cabinet_user_personal__right">
                                                    <div class="cu__personal_option">{{ $displayEmail }}</div>
                                                </div>
                                            </div>
                                        @endif

                                        @if($displayPhone)
                                            <div class="cabinet_user_personal__flex">
                                                <div class="cabinet_user_personal__left">
                                                    <div class="cu__personal_label"><span>Телефон:</span></div>
                                                </div>
                                                <div class="cabinet_user_personal__right">
                                                    <div class="cu__personal_option">{{ phone($displayPhone) }}</div>
                                                </div>
                                            </div>
                                        @endif

                                    @endif

                                    @php
                                        $displayTelegram = $item->telegram ?: ($user->telegram ?? null);
                                        $displayWhatsapp = $item->whatsapp ?: ($user->whatsapp ?? null);
                                    @endphp

                                    @if($displayTelegram)
                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>Telegram:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">{{ $displayTelegram }}</div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($displayWhatsapp)
                                        <div class="cabinet_user_personal__flex">
                                            <div class="cabinet_user_personal__left">
                                                <div class="cu__personal_label"><span>WhatsApp:</span></div>
                                            </div>
                                            <div class="cabinet_user_personal__right">
                                                <div class="cu__personal_option">{{ $displayWhatsapp }}</div>
                                            </div>
                                        </div>
                                    @endif


                                </div>

                                <br>
                                <div class="hh_box">
                                    <h2 class="h2">О себе</h2>
                                    <div class="hh__text desc">
                                        {!! $item->desc !!}
                                    </div>
                                </div>
                                <div class="hh_box">
                                    <h2 class="h2">Навыки</h2>
                                    <div class="hh__text desc">
                                        {!! $item->must !!}
                                    </div>
                                </div>
                                <div class="hh_box">
                                    <h2 class="h2">Пожелания</h2>
                                    <div class="hh__text desc">
                                        {!! $item->conditions !!}
                                    </div>
                                </div>

                                <div class="cu_row_30 cu_row hh__actions">
                                    <div class="cu__col">
                                        <a href="{{ route('my_resume_edit', $item->id) }}" class="btn btn-big btn-green"><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>Редактировать</a>
                                    </div>
                                    <div class="cu__col">
                                        <form action="{{ route('my_resume_archive_move', $item->id) }}" method="POST" id="archive-resume-form">
                                            @csrf
                                            <button type="submit" class="btn btn-big btn-indigo"><svg class="btn__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776M12 12.75l3 3m0 0-3 3m3-3H9" /></svg>В архив</button>
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
    document.getElementById('delete-resume-form').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Вы уверены, что хотите удалить это резюме? Это действие необратимо.')) {
            this.submit();
        }
    });

    document.getElementById('archive-resume-form').addEventListener('submit', function (e) {
        e.preventDefault();
        if (confirm('Переместить резюме в архив?')) {
            this.submit();
        }
    });
</script>
@endpush
