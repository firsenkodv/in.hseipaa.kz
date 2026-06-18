<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Сохранено."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b30_important">
            <div class="form_title__h1">Отчёт пользователя</div>
            <div class="form_title__h2">{{ $report->user->username ?? '' }}</div>
        </div>

        @if($report->accepted)

            <div class="manager-report-accepted-notice">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                Отчёт принят и не может быть изменён
            </div>

            <div class="manager-report-readonly">
                <div class="manager-report-readonly__row">
                    <span class="manager-report-readonly__label">Период</span>
                    <span class="manager-report-readonly__value">{{ $report->period_from->format('d.m.Y') }} — {{ $report->period_to->format('d.m.Y') }}</span>
                </div>
                <div class="manager-report-readonly__row">
                    <span class="manager-report-readonly__label">Вид отчёта</span>
                    <span class="manager-report-readonly__value">{{ $report->report_type }}</span>
                </div>
                <div class="manager-report-readonly__row">
                    <span class="manager-report-readonly__label">Дисциплина</span>
                    <span class="manager-report-readonly__value">{{ $report->discipline_name }}</span>
                </div>
                <div class="manager-report-readonly__row">
                    <span class="manager-report-readonly__label">Заведение</span>
                    <span class="manager-report-readonly__value">{{ $report->school_name }}</span>
                </div>
                @if($report->certificates && $report->certificates->isNotEmpty())
                    <div class="manager-report-readonly__row">
                        <span class="manager-report-readonly__label">Сертификаты</span>
                        <div class="manager-report-readonly__files">
                            @foreach($report->certificates as $cert)
                                <a href="{{ $cert['url'] }}" target="_blank" download class="user-reports__file">
                                    <i class="fa fa-file-pdf-o"></i>
                                    {{ basename($cert['json_file']) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        @else

            <div class="form_data app_form_data pad_b18_important">

                <input type="hidden" name="report_id" class="app_input_name" value="{{ $report->id }}">

                <div id="report-period" class="period-range-wrapper">
                    <x-form.form-input-datepicker
                        name="report_period_from"
                        label="Начало периода"
                        value="{{ $report->period_from->format('d.m.Y') }}"
                        required="{{ true }}"
                    />
                    <x-form.form-input-datepicker
                        name="report_period_to"
                        label="Конец периода"
                        value="{{ $report->period_to->format('d.m.Y') }}"
                        required="{{ true }}"
                    />
                </div>

                <x-form.form-input
                    name="report_type"
                    type="text"
                    label="Вид отчёта (обязательные дисциплины)"
                    value="{{ $report->report_type }}"
                    required="{{ true }}"
                />

                <x-form.form-input
                    name="discipline_name"
                    type="text"
                    label="Наименование дисциплины"
                    value="{{ $report->discipline_name }}"
                    required="{{ true }}"
                />

                <x-form.form-input
                    name="school_name"
                    type="text"
                    label="Наименование учебного заведения"
                    value="{{ $report->school_name }}"
                    required="{{ true }}"
                />

                @if($report->certificates && $report->certificates->isNotEmpty())
                    <div class="manager-report-certs">
                        <div class="manager-report-certs__label">Сертификат pdf</div>
                        <div class="manager-report-certs__files">
                            @foreach($report->certificates as $cert)
                                <a href="{{ $cert['url'] }}" target="_blank" download class="user-reports__file">
                                    <i class="fa fa-file-pdf-o"></i>
                                    {{ basename($cert['json_file']) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <div class="input-button" style="display:flex; gap:12px; flex-wrap:wrap;">
                <x-form.form-button url="manager_report_update">
                    Сохранить изменения
                </x-form.form-button>
                <x-form.form-button url="manager_report_accept" class="btn-green">
                    Принять отчёт
                </x-form.form-button>
            </div>

        @endif

        {{-- Чат по отчёту (всегда доступен) --}}
        <div class="report-chat"
             data-report-id="{{ $report->id }}"
             data-user-id="{{ $report->user->id ?? '' }}"
             data-send-url="/report-chat/manager-send">

            <div class="report-chat__header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                Переписка с пользователем
            </div>

            <div class="report-chat__messages">
                @forelse($messages as $msg)
                    @php
                        $senderRole = ($msg->sender_type === \App\Models\User::class) ? 'user' : 'staff';
                    @endphp
                    <x-report-chat.message :msg="$msg" :senderRole="$senderRole"/>
                @empty
                    <div class="report-chat__empty">Переписка пока не начата.</div>
                @endforelse
            </div>

            <div class="report-chat__form">
                <textarea
                    class="report-chat__textarea"
                    placeholder="Замечание к отчёту..."
                    rows="3"
                ></textarea>
                <button type="button" class="btn btn-big report-chat__send-btn">
                    Отправить
                </button>
            </div>

        </div>

    </div>
</div>
