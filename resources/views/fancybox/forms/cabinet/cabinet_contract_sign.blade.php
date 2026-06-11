<div class="modal-form-container app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Договор успешно подписан! Спасибо."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b18_important">
            <div class="form_title__h1">Подписание договора</div>
            <div class="form_title__h2">Ознакомьтесь с условиями и нажмите «Подписать»</div>
        </div>

        <div class="app_form_data" style="display:none;">
            <input type="hidden" name="contract_id" class="app_input_name" value="{{ $contract->id }}">
        </div>

        <div class="contract-sign-preview">

            <div class="contract-sign-preview__discipline">
                {{ $contract->discipline ?: '—' }}
            </div>

            <div class="contract-sign-preview__rows">

                <div class="contract-sign-preview__row">
                    <div class="contract-sign-preview__label">ФИО</div>
                    <div class="contract-sign-preview__value">{{ $contract->full_name ?: '—' }}</div>
                </div>

                <div class="contract-sign-preview__row">
                    <div class="contract-sign-preview__label">Email</div>
                    <div class="contract-sign-preview__value">{{ $contract->email ?: '—' }}</div>
                </div>

                <div class="contract-sign-preview__row">
                    <div class="contract-sign-preview__label">Телефон</div>
                    <div class="contract-sign-preview__value">{{ $contract->phone ?: '—' }}</div>
                </div>

                <div class="contract-sign-preview__row">
                    <div class="contract-sign-preview__label">Период обучения</div>
                    <div class="contract-sign-preview__value">
                        @if($contract->date_start && $contract->date_end)
                            {{ $contract->date_start->format('d.m.Y') }} — {{ $contract->date_end->format('d.m.Y') }}
                        @else
                            —
                        @endif
                    </div>
                </div>

                <div class="contract-sign-preview__row">
                    <div class="contract-sign-preview__label">Стоимость</div>
                    <div class="contract-sign-preview__value contract-sign-preview__value--price">
                        {{ number_format((float) $contract->price, 0, '.', ' ') }}&nbsp;{{ $currencySign }}
                    </div>
                </div>

                <div class="contract-sign-preview__row">
                    <div class="contract-sign-preview__label">Количество часов</div>
                    <div class="contract-sign-preview__value">{{ $contract->hours }}&nbsp;ч.</div>
                </div>

            </div>

            <div class="contract-sign-preview__notice">
                Нажимая «Подписать», вы подтверждаете своё согласие с условиями договора.
                После подписания изменение условий невозможно.
            </div>

        </div>

        <div class="input-button">
            <x-form.form-button url="cabinet_contract_sign" class="btn-green">
                Подписать
            </x-form.form-button>
        </div>

    </div>
</div>
