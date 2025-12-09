<div class="modal-form-container mini  app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response />
    <div class="modal_padding relative app_modal ">
        <div class="form_title">
            <div class="form_title__h1">Заявка на консультацию</div>
            <div class="form_title__h2">Оставьте заявку на консультацию, мы ответим вам в ближайшее время.
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
            />

        </div>
        <div class="input-button ">
            <x-form.form-button class="w_265_px_important"  url="consult_me" >Отправить</x-form.form-button>
        </div>
    </div>
</div>

