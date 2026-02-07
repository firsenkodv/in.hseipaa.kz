@props(
    ['item']
)
    <div class="cabinet-user-update_update_cabinet-user-update">

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <x-avatar.avatar-user :user="$item"
                                      :route="route('upload_rop-manager_photo')"
                                      folder="managers"
                                      :managerid="$item->id" />

            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu_username">
                    <h1 class="h1">{{ $item->username }}</h1>
                    <p class="_subtitle">{{ config('site.constants.head_sales_department') }}</p>

                </div>
            </div>
        </div>
        <div class="cabinet_user_update_handel">

            <x-form.form
                method="POST"
                :action="route('rop_update_post_manager')"
            >
                <h2 class="h2 pad_b32">Личные данные</h2>
                <div class="cu_row_50">
                    <div class="cu__col">
                        <x-form.form-input
                            name="username"
                            type="text"
                            label="ФИО"
                            value="{!!  (old('username'))?: ($item->username?:'') !!}"
                            autofocus="{{ true }}"
                            required="{{ true }}"

                        />
                    </div>
                    <div class="cu__col">
                        <x-form.form-input
                            name="phone"
                            type="tel"
                            label="Телефон"
                            value="{{ (old('phone'))?: ($item->phone?:'') }}"
                            class="imask"

                        />
                    </div>
                </div>
                        <x-form.form-input
                            name="email"
                            type="email"
                            label="Email"
                            value="{{ (old('email'))?: ($item->email?:'') }}"
                        />


                <h2 class="h2 pad_b32 pad_t20">Данные соц. сетей</h2>

                <x-form.form-input
                    name="telegram"
                    type="text"
                    label="Telegram"
                    description="Заполняйте правильно - <span>@hseipaa</span> или <span>t.me/hseipaa</span>"
                    value="{{ (old('telegram'))?: ($item->telegram?:'') }}"

                />

                <x-form.form-input
                    name="whatsapp"
                    type="text"
                    label="WhatsApp"
                    description="Указывайте только номер, без + и пробелов - <span>77075594060</span>"
                    value="{{ (old('whatsapp'))?: ($item->whatsapp?:'') }}"
                />

                <x-form.form-input
                    name="instagram"
                    type="text"
                    label="Instagram"
                    description="Указывайте только ваш аккаунт -  <span>generalre.kz</span>"
                    value="{{ (old('instagram'))?: ($item->instagram?:'') }}"
                />
                <div class="row_form_800__right pad_t20">
                    <input type="hidden" value="{{ $item->id }}" name="manager_id">
                    <button type="submit" class="btn btn-big"><span>{{ config('site.constants.cabinet_edit') }}</span></button>
                </div>

            </x-form.form>

        </div>

    </div>

