@props([
    'user',
    'route' => '#'
])

<x-form.form
    method="POST"
    :put="true"
    :action="$route"
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
            <x-form.form-input-datepicker
                name="date_birthday"
                label="Дата рождения"
                value="{{ (old('date_birthday'))?: ($user->date_birthday?:'') }}"
            />
        </div>
    </div>

    @if($user->individual)
        <div class="cu_row_100">
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

    <x-form.form-input
        name="email"
        type="email"
        label="Email"
        value="{{ (old('email'))?: ($user->email?:'') }}"
    />

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


{{--        <div class="cu_row_50">
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
        </div>--}}

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

    <h2 class="h2 pad_b20 pad_t10">{{ config('site.constants.network_message') }}
        @if(!$user->tarif_id)
            <x-form.form-exclamation
                data="cabinet_user_social_description"
            />
        @endif
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

    <h2 class="h2 pad_b20 pad_t10">{{ config('site.constants.languages') }}</h2>
    <x-form.form-checkboxes class="pad_b10"
                            name="languages[]"
                            :checkboxes="$user->user_languages"
    />


    @if($user->individual)

        <h2 class="h2 pad_b20 pad_t10">Специалист</h2>
    <p class="p_ch">Укажите квалификацию</p>
        @if(count($user->user_specialists))
            <div class="checkbox__wrapper pad_b10">
                @foreach($user->user_specialists as $specialist)
                    @php
                        $specId = $specialist['id'];
                        $hasOld = count(old()) > 0;
                        $isChecked = $hasOld
                            ? in_array((string)$specId, array_map('strval', old('specialists', [])))
                            : $specialist['checked'];
                        $certNum  = old('specialist_certificate_number.' . $specId) ?: $specialist['certificate_number'];
                        $certDate = old('specialist_certificate_date.' . $specId) ?: $specialist['certificate_date'];
                        $certDateError = 'specialist_certificate_date.' . $specId;
                        $certNumError  = 'specialist_certificate_number.' . $specId;
                    @endphp

                    <div class="checkbox__flex">
                        <div class="checkbox__left">
                            <div class="checkbox__title">{{ $specialist['title'] }}</div>
                            <div class="checkbox__subtitle">{{ $specialist['subtitle'] }}</div>
                        </div>
                        <div class="checkbox__right">
                            <div class="checkbox-wrapper-3">
                                <input type="checkbox"
                                       name="specialists[]"
                                       value="{{ $specId }}"
                                       id="spec-cbx-{{ $specId }}"
                                       class="cbx-3 js-spec-cbx"
                                       data-target="spec-cert-{{ $specId }}"
                                       @if($isChecked) checked @endif />
                                <label for="spec-cbx-{{ $specId }}" class="toggle"><span></span></label>
                            </div>
                        </div>
                    </div>

                    <div id="spec-cert-{{ $specId }}" class="specialist-cert-fields" @if(!$isChecked) style="display:none" @endif>
                        <x-form.form-input
                            name="specialist_certificate_number[{{ $specId }}]"
                            label="Номер сертификата"
                            :error="$certNumError"
                            value="{{ $certNum }}"
                        />
                        <div class="input-group app_input_group input-date-picker">
                            <input
                                data-date="{{ $certDate }}"
                                data-role="specialist-cert-date"
                                class="input-group__input app_input_name @error($certDateError) _error @enderror"
                                type="text"
                                placeholder="{{ $certDate }}"
                                name="specialist_certificate_date[{{ $specId }}]"
                                value=""
                                autocomplete="off"
                            />
                            <label class="input-group__label @if($certDate) position_top @endif">Дата выдачи сертификата</label>
                            <div class="input_error app_input_error">@error($certDateError){{ $message }}@enderror</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <h2 class="h2 pad_b20 pad_t10">Эксперт</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="experts[]"
                                :checkboxes="$user->user_experts"
        />

        <h2 class="h2 pad_b20 pad_t10">Лектор</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="lecturers[]"
                                :checkboxes="$user->user_lecturers"
        />

        <h2 class="h2 pad_b20 pad_t10">Квалификации</h2>
        <p class="p_ch">Укажите квалификации и номер документа</p>
        @if(count($user->user_file_qualifications))
            <div class="checkbox__wrapper pad_b10">
                @foreach($user->user_file_qualifications as $qualification)
                    @php
                        $qualId = $qualification['id'];
                        $hasOld = count(old()) > 0;
                        $isChecked = $hasOld
                            ? in_array((string)$qualId, array_map('strval', old('qualifications', [])))
                            : $qualification['checked'];
                        $docNum = old('qualification_custom_documents.' . $qualId) ?: $qualification['custom_documents'];
                        $docNumError = 'qualification_custom_documents.' . $qualId;
                    @endphp

                    <div class="checkbox__flex">
                        <div class="checkbox__left">
                            <div class="checkbox__title">{{ $qualification['title'] }}</div>
                            <div class="checkbox__subtitle">{{ $qualification['subtitle'] }}</div>
                        </div>
                        <div class="checkbox__right">
                            <div class="checkbox-wrapper-3">
                                <input type="checkbox"
                                       name="qualifications[]"
                                       value="{{ $qualId }}"
                                       id="qual-cbx-{{ $qualId }}"
                                       class="cbx-3 js-qual-cbx"
                                       data-target="qual-doc-{{ $qualId }}"
                                       @if($isChecked) checked @endif />
                                <label for="qual-cbx-{{ $qualId }}" class="toggle"><span></span></label>
                            </div>
                        </div>
                    </div>

                    <div id="qual-doc-{{ $qualId }}" class="specialist-cert-fields" @if(!$isChecked) style="display:none" @endif>
                        <x-form.form-input
                            name="qualification_custom_documents[{{ $qualId }}]"
                            label="Номер документа"
                            :error="$docNumError"
                            value="{{ $docNum }}"
                        />
                    </div>
                @endforeach
            </div>
        @endif
    @endif
    @if($user->legal_entity)
        <h2 class="h2 pad_b20 pad_t10">Вид деятельности</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="productions[]"
                                :checkboxes="$user->user_productions"
        />
    @endif
    <div class="download_files">
        <h2 class="h2">Загрузка файлов</h2>
        <div class="download_files__wrap">
            <div class="download_files__cover"></div>

            <x-form.form-upload-files
                :value="$user->file_id_card"
                :id="$user->id"
                name="file_id_card"
                class="pad_b10 pad_t20"
                title="Удостоверение личности"
            />

            <x-form.form-upload-files
                :value="$user->file_criminal_record"
                :id="$user->id"
                name="file_criminal_record"
                class="pad_b10"
                title="Справка об отсутствии судимости"
            />

            <x-form.form-upload-files
                :value="$user->file_dispensary"
                :id="$user->id"
                name="file_dispensary"
                class="pad_b10"
                title="Справка с псих. диспансера"
            />

            <x-form.form-upload-files
                :value="$user->file_diploma_education"
                :id="$user->id"
                name="file_diploma_education"
                class="pad_b10"
                title="Диплом о высшем образовании"
            />

            <x-form.form-upload-files
                :value="$user->file_accountant_certificate"
                :id="$user->id"
                name="file_accountant_certificate"
                class="pad_b10"
                title="Сертификат бухгалтера"
            />

            <x-form.form-upload-files
                :value="$user->file_scientific_degrees"
                :id="$user->id"
                name="file_scientific_degrees"
                class="pad_b10"
                title="Научные степени"
            />


            @if($user->legal_entity)
                <x-form.form-upload-files
                    :value="$user->file_legal_registration"
                    :id="$user->id"
                    name="file_legal_registration"
                    class="pad_b10"
                    title="Справка о регистрации компании"
                />

                <x-form.form-upload-files
                    :value="$user->file_legal_regulation"
                    :id="$user->id"
                    name="file_legal_regulation"
                    class="pad_b10"
                    title="Устав"
                />

                <x-form.form-upload-files
                    :value="$user->file_legal_first_boss"
                    :id="$user->id"
                    name="file_legal_first_boss"
                    class="pad_b10"
                    title="Приказ на первого руководителя"
                />

            @endif
        </div>
    </div>
    <div class="row_form_800__right">
        <input type="hidden" name="id" value="{{ $user->id }}">
        <button type="submit" class="btn btn-big"><span>{{ config('site.constants.cabinet_edit') }}</span></button>
    </div>

</x-form.form>

<script>
document.querySelectorAll('.js-spec-cbx, .js-qual-cbx').forEach(function (cbx) {
    cbx.addEventListener('change', function () {
        var target = document.getElementById(this.dataset.target);
        if (target) {
            target.style.display = this.checked ? '' : 'none';
        }
    });
});
</script>
