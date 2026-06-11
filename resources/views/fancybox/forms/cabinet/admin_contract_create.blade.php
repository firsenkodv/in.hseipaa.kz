<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Договор успешно создан. Данные отправлены пользователю на email."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b30_important">
            <div class="form_title__h1">Создать договор</div>
            <div class="form_title__h2">После создания договора он отправится на подписание пользователю</div>
        </div>

        <div class="form_data app_form_data pad_b18_important">

            <input type="hidden" name="user_id" class="app_input_name" value="{{ $user->id }}">

            <x-form.form-input
                name="fio"
                type="text"
                label="ФИО"
                value="{{ $user->username }}"
                required="{{ true }}"
                autofocus="{{ true }}"
            />

            <x-form.form-input
                name="email"
                type="email"
                label="Email"
                value="{{ $user->email }}"
                autocomplete="email"
                required="{{ true }}"
            />

            <x-form.form-input
                name="phone"
                type="tel"
                label="Телефон"
                class="imask"
                value="{{ $user->phone }}"
                required="{{ true }}"
            />

            <x-form.form-select-cabinet
                name="training_id"
                label="Выбрать дисциплину"
                :options="$trainings"
                required="{{ true }}"
            />

            <x-form.form-select-cabinet
                name="organization"
                label="Организация обучения"
                :options="$organizations"
                required="{{ true }}"
            />

            <div id="contract-period" class="period-range-wrapper">
                <x-form.form-input-datepicker
                    name="date_from"
                    label="Дата начала"
                    required="{{ true }}"
                />
                <x-form.form-input-datepicker
                    name="date_to"
                    label="Дата окончания"
                    required="{{ true }}"
                />
            </div>

            <div class="period-range-wrapper">
                <x-form.form-input
                    name="price"
                    type="text"
                    label="Стоимость"
                    required="{{ true }}"
                />

                <x-form.form-select-cabinet
                    name="currency"
                    label="Валюта"
                    :options="collect($currencies)->map(fn($sign, $code) => ['id' => $code, 'title' => $sign])->values()->toArray()"
                    :selected="$currencies[$defaultCurrency]"
                    :value="$defaultCurrency"
                    required="{{ true }}"
                />
            </div>

            <x-form.form-input
                name="hours"
                type="text"
                label="Количество часов"
                required="{{ true }}"
            />

        </div>

        <div class="input-button">
            <x-form.form-button url="admin_contract_create">
                Создать договор
            </x-form.form-button>
        </div>

    </div>
</div>
