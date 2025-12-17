<div class="form_form-blue-component">
    <section class="form_blue__padding">
        <div class="block relative app_form_modal">
            <x-form.form-loader/>
            <x-form.form-response />
            <div class="app_form_data">

            <div class="background_575EEF app_modal">
                <h4 class="h2">Оставьте заявку - мы обсудим ваши цели и подберем решения</h4>

                <div class="form_blue">
                    <div class="form_blue__flex">
                        <x-form.form-input
                            name="Телефон"
                            type="tel"
                            label="Телефон"
                            class="imask"
                            value="{{ old('Телефон')?:'' }}"
                            required="{{ true }}"
                        />
                        <x-form.form-input
                            name="ФИО"
                            type="text"
                            label="ФИО"
                            value="{{ old('ФИО')?:'' }}"
                            required="{{ true }}"
                        />
                        <x-form.form-input
                            name="Email"
                            type="email"
                            label="Email"
                            value="{{ old('Email')?:'' }}"
                            required="{{ true }}"
                        />
                        <div class="input-button ">
                            <x-form.form-button class="w_265_px_important"  url="call_me_blue" >Отправить</x-form.form-button>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

</div>

