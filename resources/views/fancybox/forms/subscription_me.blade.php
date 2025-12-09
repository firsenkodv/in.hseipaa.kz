<div class="modal-form-container mini  app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response />
    <div class="modal_padding relative app_modal ">
        <div class="form_title">
            <div class="form_title__h1">Заявка на подписку</div>
            <div class="form_title__h2">У вас будет бухгалтер который будет сопровождать вас во время подписки на
                услугу.
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
                class="imask"
                value="{{ old('Телефон')?:'' }}"
                required="{{ true }}"


            />
            <x-form.form-input
                name="Email"
                type="email"
                label="Email"
                value="{{ old('Email')?:'' }}"
                autocomplete="email"
            />

        </div>
        <div class="input-button ">
            <x-form.form-button class="w_265_px_important"  url="subscription_me" >Отправить</x-form.form-button>
        </div>
    </div>
</div>
