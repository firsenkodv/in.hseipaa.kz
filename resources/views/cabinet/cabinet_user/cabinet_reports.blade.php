@extends('layouts.layout')
<x-seo.meta
    title="Мои отчёты"
    description="Мои отчёты"
    keywords="Мои отчёты"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_reports') }}
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
                        <div class="form_title__h1">Отчёты</div>
                        <div class="form_title__h2">Список отчётов об обучении</div>
                    </div>

                    <div style="margin-bottom: 4px;">
                        <a href="#"
                           class="btn btn-big open-fancybox"
                           data-form="user_report_create">
                            Создать новый отчёт
                        </a>
                    </div>

                    @if($reports->isNotEmpty())
                        <div class="user-reports">
                            @foreach($reports as $report)
                                <div class="user-reports__item" data-report-id="{{ $report->id }}">

                                    <div class="user-reports__top">
                                        <div class="user-reports__title">
                                            Отчёт за {{ $report->period_from->format('d.m.Y') }} — {{ $report->period_to->format('d.m.Y') }}
                                            <span class="user-reports__date">от {{ $report->created_at->format('d.m.Y') }}</span>
                                        </div>
                                        @if($report->accepted)
                                            <span class="user-reports__badge user-reports__badge--accepted">Принят</span>
                                        @endif
                                    </div>

                                    <div class="user-reports__rows">

                                        <div class="user-reports__row">
                                            <span class="user-reports__label">Вид отчёта</span>
                                            <span class="user-reports__value">{{ $report->report_type }}</span>
                                        </div>

                                        <div class="user-reports__row">
                                            <span class="user-reports__label">Дисциплина</span>
                                            <span class="user-reports__value">{{ $report->discipline_name }}</span>
                                        </div>

                                        <div class="user-reports__row">
                                            <span class="user-reports__label">Заведение</span>
                                            <span class="user-reports__value">{{ $report->school_name }}</span>
                                        </div>

                                        @if($report->certificates && $report->certificates->isNotEmpty())
                                           <br> <div class="user-reports__row">
                                                <span class="user-reports__label">Сертификаты</span>
                                                <div class="user-reports__files">
                                                    @foreach($report->certificates as $cert)
                                                        <a href="{{ $cert['url'] }}" target="_blank" class="user-reports__file">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                            {{ basename($cert['json_file']) }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="user-reports__actions">
                                        @if(!$report->accepted)
                                            <a href="#"
                                               class="open-fancybox user-reports__edit-btn"
                                               data-form="user_report_edit"
                                               data-transfer='{"report_id": {{ $report->id }}}'>
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                                Редактировать
                                            </a>
                                        @endif
                                        <a href="#"
                                           class="open-fancybox user-reports__chat-btn"
                                           data-form="report_chat_user"
                                           data-transfer='{"report_id": {{ $report->id }}}'>
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                            </svg>
                                            Переписка
                                            @if(($unreadCounts[$report->id] ?? 0) > 0)
                                                <span class="user-reports__unread-badge">{{ $unreadCounts[$report->id] }}</span>
                                            @endif
                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="form_title" style="margin-top: 28px;">
                            <div class="form_title__h2">У вас пока нет отчётов. Нажмите «Создать новый отчёт», чтобы добавить первый.</div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </section>
@endsection
