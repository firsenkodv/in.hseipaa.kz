<div class="modal-form-container mini  app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response />
    <div class="modal_padding relative app_modal ">
        <div class="form_title">
            <div class="form_title__h1">Отправить заявку</div>
            <div class="form_title__h2">Оставьте заявку на обучение, мы ответим вам в ближайшее время.
            </div>
        </div>
        <div class="form_data app_form_data">

            <x-form.form-input
                name="ФИО"
                type="text"
                label="ФИО"
                value="{{ old('ФИО')?:'' }}"
                autofocus="{{ true }}"
                required="{{ true }}"

            />

            <x-form.form-input
                name="Телефон"
                type="tel"
                label="Телефон"
                value="{{ old('Телефон')?:'' }}"
                class="imask"
                required="{{ true }}"

            />

            <x-form.form-input
                name="Email"
                type="email"
                label="Email"
                value="{{ old('Email')?:'' }}"
                autocomplete="email"
                required="{{ true }}"

            />

            <x-form.form-select
                :title="config2('moonshine.setting.f1_title')" {{-- Курсы бухгалтера --}}
                :name="config2('moonshine.setting.f1_label')" {{-- Курсы --}}
                value="{{ old(config2('moonshine.setting.f1_label')) ?: '' }}"
                :options="config2('moonshine.setting.json_accountant_training')"
                required="{{ true }}"



            />

            <x-form.form-select
                :title="config2('moonshine.setting.f2_title')" {{-- Консультации --}}
                :name="config2('moonshine.setting.f2_label')" {{-- Услуги бухгалтера --}}
                value="{{ old(config2('moonshine.setting.f2_label')) ?: '' }}"
                :options="config2('moonshine.setting.json_accountant_services')"
                required="{{ true }}"


            />





        </div>
        <div class="input-button ">
            <x-form.form-button class="w_265_px_important"  url="request_for_training" >Отправить</x-form.form-button>
        </div>
    </div>
</div>

