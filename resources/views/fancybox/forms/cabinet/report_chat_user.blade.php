<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Сообщение отправлено."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b30_important">
            <div class="form_title__h1">Переписка</div>
            <div class="form_title__h2">
                Отчёт за {{ $report->period_from->format('d.m.Y') }} — {{ $report->period_to->format('d.m.Y') }}
            </div>
        </div>

        <div class="report-chat"
             data-report-id="{{ $report->id }}"
             data-send-url="/report-chat/user-send">

            <div class="report-chat__messages" id="report-chat-messages-{{ $report->id }}">
                @forelse($messages as $msg)
                    @php
                        $senderRole = ($msg->sender_type === \App\Models\User::class) ? 'user' : 'staff';
                    @endphp
                    <x-report-chat.message :msg="$msg" :senderRole="$senderRole"/>
                @empty
                    <div class="report-chat__empty">Сообщений пока нет. Напишите свой ответ.</div>
                @endforelse
            </div>

            <div class="report-chat__form">
                <textarea
                    class="report-chat__textarea"
                    placeholder="Ваш ответ менеджеру..."
                    rows="3"
                ></textarea>
                <button type="button" class="btn btn-big report-chat__send-btn">
                    Отправить
                </button>
            </div>

        </div>

    </div>
</div>
