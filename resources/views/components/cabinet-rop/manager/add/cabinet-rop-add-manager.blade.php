<div class="cabinet-user-add_add_cabinet-user-add">

    <div class="cabinet_user_update_handel">

        <x-form.form
            method="POST"
            :action="route('rop_add_post_manager')"
        >
            <h2 class="h2 pad_b32">Личные данные</h2>
            <div class="cu_row_50">
                <div class="cu__col">
                    <x-form.form-input
                        name="username"
                        type="text"
                        label="ФИО"
                        value="{!!  (old('username'))?: '' !!}"
                        autofocus="{{ true }}"
                        required="{{ true }}"

                    />
                </div>
                <div class="cu__col">
                    <x-form.form-input
                        name="phone"
                        type="tel"
                        label="Телефон"
                        value="{{ (old('phone'))?:'' }}"
                        class="imask"

                    />
                </div>
            </div>
            <div class="cu_row_50">
                <div class="cu__col">
            <x-form.form-input
                name="email"
                type="email"
                label="Email"
                value="{{ (old('email'))?:''}}"
            />
                </div>
                <div class="cu__col">
                    <x-form.form-input
                        name="password"
                        type="password"
                        label="Пароль"
                        required="{{ true }}"

                    />
                </div>
            </div>

            <h2 class="h2 pad_b32 pad_t20">Данные соц. сетей</h2>

            <x-form.form-input
                name="telegram"
                type="text"
                label="Telegram"
                description="Заполняйте правильно - <span>@hseipaa</span> или <span>t.me/hseipaa</span>"
                value="{{ (old('telegram'))?:'' }}"

            />

            <x-form.form-input
                name="whatsapp"
                type="text"
                label="WhatsApp"
                description="Указывайте только номер, без + и пробелов - <span>77075594060</span>"
                value="{{ (old('whatsapp'))?:'' }}"
            />

            <x-form.form-input
                name="instagram"
                type="text"
                label="Instagram"
                description="Указывайте только ваш аккаунт -  <span>generalre.kz</span>"
                value="{{ (old('instagram'))?:'' }}"
            />
            <div class="row_form_800__right pad_t20">
                <button type="submit" class="btn btn-big"><span>{{ config('site.constants.well_yellow') }}</span></button>
            </div>

        </x-form.form>

    </div>

</div>
