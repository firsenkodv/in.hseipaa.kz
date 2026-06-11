<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Договор успешно обновлён."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b30_important">
            <div class="form_title__h1">Редактировать договор</div>
            <div class="form_title__h2">Изменения применятся сразу после сохранения</div>
        </div>

        <div class="form_data app_form_data pad_b18_important">

            <input type="hidden" name="contract_id" class="app_input_name" value="{{ $contract->id }}">

            <x-form.form-input
                name="fio"
                type="text"
                label="ФИО"
                value="{{ $contract->full_name }}"
                required="{{ true }}"
                autofocus="{{ true }}"
            />

            <x-form.form-input
                name="email"
                type="email"
                label="Email"
                value="{{ $contract->email }}"
                autocomplete="email"
                required="{{ true }}"
            />

            <x-form.form-input
                name="phone"
                type="tel"
                label="Телефон"
                class="imask"
                value="{{ $contract->phone }}"
                required="{{ true }}"
            />

            <x-form.form-select-cabinet
                name="training_id"
                label="Выбрать дисциплину"
                :options="$trainings"
                :selected="$contract->discipline"
                :value="$trainingId"
                required="{{ true }}"
            />

            <div id="contract-period" class="period-range-wrapper">
                <x-form.form-input-datepicker
                    name="date_from"
                    label="Дата начала"
                    value="{{ $contract->date_start ? $contract->date_start->format('d.m.Y') : '' }}"
                    required="{{ true }}"
                />
                <x-form.form-input-datepicker
                    name="date_to"
                    label="Дата окончания"
                    value="{{ $contract->date_end ? $contract->date_end->format('d.m.Y') : '' }}"
                    required="{{ true }}"
                />
            </div>

            <div class="period-range-wrapper">
                <x-form.form-input
                    name="price"
                    type="text"
                    label="Стоимость"
                    value="{{ (string)(int)$contract->price }}"
                    required="{{ true }}"
                />

                <x-form.form-select-cabinet
                    name="currency"
                    label="Валюта"
                    :options="collect($currencies)->map(fn($sign, $code) => ['id' => $code, 'title' => $sign])->values()->toArray()"
                    :selected="$currencyDisplay"
                    :value="$currencyCode"
                    required="{{ true }}"
                />
            </div>

            <x-form.form-input
                name="hours"
                type="text"
                label="Количество часов"
                value="{{ $contract->hours }}"
                required="{{ true }}"
            />

        </div>

        <div class="input-button">
            <x-form.form-button url="admin_contract_update">
                Сохранить изменения
            </x-form.form-button>
        </div>

    </div>
</div>
