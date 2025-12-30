@if(!is_null($user))

    <div class="cabinet-user-update_update_cabinet-user-update">

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <x-avatar.avatar-user :user="$user"/>

            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu_username">
                    <h1 class="h1">{{ $user->username }}</h1>
                    @if($user->UserHuman)
                        <p class="_subtitle">{{ $user->UserHuman->title }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="cabinet_user_update_handel">

            <x-form.form
                method="POST"
                :action="route('cabinet_user_update_handel')"
            >
                <h2 class="h2 pad_b32">Личные данные</h2>
                <div class="cu_row_50">
                    <div class="cu__col">
                        <x-form.form-input
                            name="username"
                            type="text"
                            label="ФИО"
                            value="{!!  (old('username'))?: ($user->username?:'') !!}"
                            autofocus="{{ true }}"
                            required="{{ true }}"

                        />
                    </div>
                    <div class="cu__col">

                        @if($user->user_sexes)
                            <x-form.form-select-cabinet
                                name="{{ (is_null($user->UserSex))? 'Укажите пол' : $user->UserSex->title}}"
                                selected="{{ (is_null($user->UserSex))? '' : $user->UserSex->title}}"
                                value="{{ (is_null($user->UserSex))? '' : $user->UserSex->id}}"
                                :options="$user->user_sexes"
                                field_name="user_sex_id"
                            />
                        @endif
                    </div>
                </div>


                @if($user->individual)
                    <div class="cu_row_50">
                        <div class="cu__col">
                            <x-form.form-input
                                name="phone"
                                type="tel"
                                label="Телефон"
                                value="{{ (old('phone'))?: ($user->phone?:'') }}"
                                class="imask"

                            />
                        </div>
                        <div class="cu__col">
                            <x-form.form-input
                                name="iin"
                                type="text"
                                label="ИИН"
                                value="{!!  (old('iin'))?: ($user->iin?:'') !!}"

                            />
                        </div>
                    </div>
                @endif
                @if($user->legal_entity)
                    <x-form.form-input
                        name="phone"
                        type="tel"
                        label="Телефон"
                        value="{{ (old('phone'))?: ($user->phone?:'') }}"
                        class="imask"

                    />
                @endif

                <div class="cu_row_50">
                    <div class="cu__col">
                        <x-form.form-input
                            name="email"
                            type="email"
                            label="Email"
                            value="{{ (old('email'))?: ($user->email?:'') }}"

                        />
                    </div>
                    <div class="cu__col">
                        <x-form.form-input-datepicker
                            name="date_birthday"
                            label="Дата рождения"
                            value="{{ (old('date_birthday'))?: ($user->date_birthday?:'') }}"

                        />
                    </div>
                </div>

                <x-form.form-textarea
                    name="about_me"
                    label="Напишите коротко о себе для анкеты"
                    value="{!!  (old('about_me'))?: (($user->about_me)?:'') !!}"

                />


                <x-form.form-textarea
                    name="experience"
                    label="Опыт работы"
                    value="{!!  (old('experience'))?: (($user->experience)?:'') !!}"

                />



                <h2 class="h2 pad_b15 pad_t10">Адрес</h2>
                @if($user->user_cities)
                    <x-form.form-select-cabinet
                        title="Город"
                        name="{{ (is_null($user->UserCity))? 'Выбрать город' : $user->UserCity->title}}"
                        selected="{{ (is_null($user->UserCity))? '' : $user->UserCity->title}}"
                        value="{{ (is_null($user->UserCity))? '' : $user->UserCity->id}}"
                        :options="$user->user_cities"
                        field_name="user_city_id"
                    />
                @endif

                <x-form.form-input
                    name="address[json_address_area]"
                    type="text"
                    label="Область"
                    error="address.json_address_area"
                    value="{!!  (old('address.json_address_area')) ? :
(isset($user->address['json_address_area'])?$user->address['json_address_area']:'') !!}"

                />
                <div class="cu_row_50">
                    <div class="cu__col">

                        <x-form.form-input
                            name="address[json_address_post_index]"
                            type="text"
                            label="Индекс"
                            error="address.json_address_post_index"
                            value="{!!  (old('address.json_address_post_index')) ? :
(isset($user->address['json_address_post_index'])?$user->address['json_address_post_index']:'') !!}"
                        />
                    </div>
                    <div class="cu__col">

                        <x-form.form-input
                            name="address[json_address_street]"
                            type="text"
                            label="Улица"
                            error="address.json_address_street"
                            value="{!!  (old('address.json_address_street')) ? :
(isset($user->address['json_address_street'])?$user->address['json_address_street']:'') !!}"


                        />
                    </div>
                </div>
                <div class="cu_row_50">
                    <div class="cu__col">

                        <x-form.form-input
                            name="address[json_address_house]"
                            type="text"
                            label="Дом"
                            error="address.json_address_house"
                            value="{!!  (old('address.json_address_house')) ? :
(isset($user->address['json_address_house'])?$user->address['json_address_house']:'') !!}"

                        />
                    </div>
                    <div class="cu__col">

                        <x-form.form-input
                            name="address[json_address_office]"
                            type="text"
                            label="Ул./Офис"
                            error="address.json_address_office"
                            value="{!!  (old('address.json_address_office')) ? :
(isset($user->address['json_address_office'])?$user->address['json_address_office']:'') !!}"

                        />
                    </div>
                </div>

                @if($user->individual)
                    <h2 class="h2 pad_b32 pad_t10">Место работы</h2>

                    <x-form.form-input
                        name="accountant_work"
                        type="text"
                        label="Место работы (наименование организации)"
                        value="{!!  (old('accountant_work'))?: ($user->accountant_work?:'') !!}"

                    />
                    <x-form.form-input
                        name="accountant_position"
                        type="text"
                        label="Должность"
                        value="{!!  (old('accountant_position'))?: ($user->accountant_position?:'') !!}"

                    />


                    <div class="cu_row_50">
                        <div class="cu__col">

                            <x-form.form-input
                                name="accountant_ticket"
                                type="text"
                                label="Номер сертификата профессионального бухгалтера"
                                value="{{ (old('accountant_ticket'))?: ($user->accountant_ticket?:'') }}"
                            />
                        </div>
                        <div class="cu__col">
                            <x-form.form-input-datepicker
                                name="accountant_ticket_date"
                                label="Дата выдачи сертификата проф. бухгалтера"
                                value="{{ (old('accountant_ticket_date'))?: ($user->accountant_ticket_date?:'') }}"

                            />

                        </div>
                    </div>

                @endif

                @if($user->legal_entity)
                    <h2 class="h2 pad_b20 pad_t10">Данные юридического лица</h2>

                    <x-form.form-input
                        name="bin"
                        type="text"
                        label="БИН"
                        value="{!!  (old('bin'))?: ($user->bin?:'') !!}"

                    />
                    <x-form.form-input
                        name="company"
                        type="text"
                        label="Компания"
                        value="{!!  (old('company'))?: ($user->company?:'') !!}"

                    />
                    <x-form.form-input
                        name="position_boss"
                        type="text"
                        label="ФИО первого руководителя"
                        value="{{ (old('position_boss'))?: ($user->position_boss?:'') }}"

                    />
                @endif

                <h2 class="h2 pad_b20 pad_t10">Социальные сети и мессенджеры
                    <x-form.form-exclamation
                    data="cabinet_user_social_description"
                    />
                </h2>

                <x-form.form-input
                    name="telegram"
                    type="text"
                    label="Telegram"
                    description="Заполняйте правильно - <span>@hseipaa</span> или <span>t.me/hseipaa</span>"
                    value="{{ (old('telegram'))?: ($user->telegram?:'') }}"

                />

                <x-form.form-input
                    name="whatsapp"
                    type="text"
                    label="WhatsApp"
                    description="Указывайте только номер, без + и пробелов - <span>77075594060</span>"
                    value="{{ (old('whatsapp'))?: ($user->whatsapp?:'') }}"
                />

                <x-form.form-input
                    name="instagram"
                    type="text"
                    label="Instagram"
                    description="Указывайте только ваш аккаунт -  <span>generalre.kz</span>"
                    value="{{ (old('instagram'))?: ($user->instagram?:'') }}"
                />

                <x-form.form-input
                    name="website"
                    type="text"
                    label="WebSite"
                    description="Ваш сайт в любом виде -  <span>https://in.hseipaa.kz/</span>"
                    value="{{ (old('website'))?: (($user->site_utf8)?:'') }}"
                />

               <h2 class="h2 pad_b20 pad_t10">Владение языками</h2>
               <x-form.form-checkboxes  class="pad_b10"
                                        name="languages[]"
                                        :checkboxes="$user->user_languages"
                                        />

               <h2 class="h2 pad_b20 pad_t10">Специалист</h2>
               <x-form.form-checkboxes  class="pad_b10"
                                        name="specialists[]"
                                        :checkboxes="$user->user_specialists"
                                        />

               <h2 class="h2 pad_b20 pad_t10">Эксперт</h2>
               <x-form.form-checkboxes  class="pad_b10"
                                        name="experts[]"
                                        :checkboxes="$user->user_experts"
                                        />

                <h2 class="h2 pad_b20 pad_t15">Лектор</h2>
               <x-form.form-checkboxes  class="pad_b40"
                                        name="lecturers[]"
                                        :checkboxes="$user->user_lecturers"
                                        />



                <div class="row_form_800__right">
                    <button type="submit" class="btn btn-big"><span>Редактировать профиль</span></button>
                </div>

            </x-form.form>

        </div>

    </div>
@endif
