@props([
    'user',
    'role' => '',
])
<div class="cabinet_user-no-edit">
  {{--  <x-content.registry.teaser :item="$user"/>--}}

    <div class="cabinet_user_personal__flex">
        <div class="cabinet_user_personal__left">
            <x-avatar.avatar-user :user="$user"
                                  :route="route('upload_rop-user_photo')"
                                  folder="users"
                                  :userid="$user->id"
                                  :readonly="true"
            />

        </div>
        <div class="cabinet_user_personal__right">
            <div class="flex in-edit">
                <div class="cu_username left">
                    <h1 class="h1">{{ $user->username }}</h1>
                    <p class="_subtitle">
                        {{ (isset($user->UserCity->title))? $user->UserCity->title : 'Город не указан' }}
                    </p>
                    <p class="{{ \App\Enums\User\PublishedUserEnum::fromValue($user->published)->class() }}">
                        {{ $user->published_user }}
                    </p>
                </div>
                <div class="right">


                    <x-cabinet.message.to-user :item="$user" :role="$role" />


                </div>
            </div>
        </div>

    </div>

<div class="pad_t40">
    <h2 class="h2 pad_b32">Личные данные</h2>
    <div class="cu_row_50">
        <div class="cu__col">
            <x-form.form-label
                label="ФИО"
                value="{!!  (old('username'))?: ($user->username?:'') !!}"
            />
        </div>
        <div class="cu__col">
            @if($user->user_sexes)
                <x-form.form-label
                    label="Пол"
                    value="{{ (is_null($user->UserSex))? '' : $user->UserSex->title}}"
                />
            @else
                <x-form.form-label
                    label="Пол"
                    class="alert"
                    value="Пол не указан"
                />
            @endif
        </div>
    </div>


    @if($user->individual)
        <div class="cu_row_50">
            <div class="cu__col">
                <x-form.form-label
                    label="Телефон"
                    value="{{ (old('phone'))?: ($user->phone?:'') }}"
                />
            </div>
            <div class="cu__col">
                <x-form.form-label
                    label="ИИН"
                    value="{!!  (old('iin'))?: ($user->iin?:'') !!}"
                />

            </div>
        </div>
    @endif
    @if($user->legal_entity)
        <x-form.form-label
            label="Телефон"
            value="{{ (old('phone'))?: ($user->phone?:'') }}"
        />
    @endif

    <div class="cu_row_50">
        <div class="cu__col">
            <x-form.form-label
                label="Email"
                value="{{ (old('email'))?: ($user->email?:'') }}"
            />
        </div>
        <div class="cu__col">
            <x-form.form-label
                label="Дата рождения"
                value="{{ (old('date_birthday'))?: ($user->date_birthday?:'') }}"
            />
        </div>
    </div>

    <x-form.form-label
        class="pad_t15_important pad_b15_important"
        label="Напишите коротко о себе для анкеты"
        value="{!!  (old('about_me'))?: (($user->about_me)?:'') !!}"

    />


    <x-form.form-label
        class="pad_t15_important pad_b15_important"
        label="Опыт работы"
        value="{!!  (old('experience'))?: (($user->experience)?:'') !!}"

    />


    <h2 class="h2 pad_b15 pad_t10">Адрес</h2>
    @if($user->user_cities)
        <x-form.form-label
            label="Город"
            value="{{ (is_null($user->UserCity))? '' : $user->UserCity->title}}"
        />
    @else
        <x-form.form-label
            class="alert"
            label="Город"
            value="Город не указан"
        />
    @endif

    <x-form.form-label
        label="Область"
        value="{!!  (old('address.json_address_area')) ? :
(isset($user->address['json_address_area'])?$user->address['json_address_area']:'') !!}"/>

    <div class="cu_row_50">
        <div class="cu__col">

            <x-form.form-label
                label="Индекс"
                value="{!!  (old('address.json_address_post_index')) ? :
(isset($user->address['json_address_post_index'])?$user->address['json_address_post_index']:'') !!}"/>

        </div>
        <div class="cu__col">
            <x-form.form-label
                label="Улица"
                value="{!!  (old('address.json_address_street')) ? :
(isset($user->address['json_address_street'])?$user->address['json_address_street']:'') !!}"/>

        </div>
    </div>
    <div class="cu_row_50">
        <div class="cu__col">
            <x-form.form-label
                label="Дом"
                value="{!!  (old('address.json_address_house')) ? :
(isset($user->address['json_address_house'])?$user->address['json_address_house']:'') !!}" />

        </div>
        <div class="cu__col">
            <x-form.form-label
                label="Ул./Офис"
                value="{!!  (old('address.json_address_office')) ? :
(isset($user->address['json_address_office'])?$user->address['json_address_office']:'') !!}"
            />

        </div>
    </div>

    @if($user->individual)
        <h2 class="h2 pad_b32 pad_t10">Место работы</h2>
        <x-form.form-label
            label="Место работы (наименование организации)"
            value="{!!  (old('accountant_work'))?: ($user->accountant_work?:'') !!}" />

        <x-form.form-label
            label="Должность"
            value="{!!  (old('accountant_position'))?: ($user->accountant_position?:'') !!}" />

        <div class="cu_row_50">
            <div class="cu__col">


                <x-form.form-label
                    label="Номер сертификата профессионального бухгалтера"
                    value="{{ (old('accountant_ticket'))?: ($user->accountant_ticket?:'') }}"
                />

            </div>
            <div class="cu__col">
                <x-form.form-label
                    label="Дата выдачи сертификата проф. бухгалтера"
                    value="{{ (old('accountant_ticket_date'))?: ($user->accountant_ticket_date?:'') }}"

                />

            </div>
        </div>

    @endif

    @if($user->legal_entity)
        <h2 class="h2 pad_b20 pad_t10">Данные юридического лица</h2>

        <x-form.form-label
            label="БИН"
            value="{!!  (old('bin'))?: ($user->bin?:'') !!}"

        />
        <x-form.form-label
            label="Компания"
            value="{!!  (old('company'))?: ($user->company?:'') !!}"

        />
        <x-form.form-label
            label="ФИО первого руководителя"
            value="{{ (old('position_boss'))?: ($user->position_boss?:'') }}"

        />
    @endif

    <h2 class="h2 pad_b20 pad_t10">{{ config('site.constants.network_message') }}
    </h2>

    <x-form.form-label
        label="Telegram"
        description="Заполняйте правильно - <span>@hseipaa</span> или <span>t.me/hseipaa</span>"
        value="{{ (old('telegram'))?: ($user->telegram?:'') }}"

    />

    <x-form.form-label

        label="WhatsApp"
        description="Указывайте только номер, без + и пробелов - <span>77075594060</span>"
        value="{{ (old('whatsapp'))?: ($user->whatsapp?:'') }}"
    />

    <x-form.form-label

        label="Instagram"
        description="Указывайте только ваш аккаунт -  <span>generalre.kz</span>"
        value="{{ (old('instagram'))?: ($user->instagram?:'') }}"
    />

    <x-form.form-label

        label="WebSite"
        description="Ваш сайт в любом виде -  <span>https://in.hseipaa.kz/</span>"
        value="{{ (old('website'))?: (($user->site_utf8)?:'') }}"
    />

    <h2 class="h2 pad_b20 pad_t10">{{ config('site.constants.languages') }}</h2>
    <x-form.form-checkboxes class="pad_b10"
                            name="languages[]"
                            :disabled="true"
                            :checkboxes="$user->user_languages"
    />


    @if($user->individual)

        <h2 class="h2 pad_b20 pad_t10">Специалист</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="specialists[]"
                                :disabled="true"
                                :checkboxes="$user->user_specialists"
        />

        <h2 class="h2 pad_b20 pad_t10">Эксперт</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="experts[]"
                                :disabled="true"
                                :checkboxes="$user->user_experts"
        />

        <h2 class="h2 pad_b20 pad_t10">Лектор</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="lecturers[]"
                                :disabled="true"
                                :checkboxes="$user->user_lecturers"
        />
    @endif
    @if($user->legal_entity)
        <h2 class="h2 pad_b20 pad_t10">Вид деятельности</h2>
        <x-form.form-checkboxes class="pad_b10"
                                name="productions[]"
                                :disabled="true"
                                :checkboxes="$user->user_productions"
        />
    @endif
    <div class="download_files">
        <h2 class="h2">Загрузка файлов</h2>
        <div class="download_files__wrap">
            <div class="download_files__cover"></div>


            <x-form.form-files
                :value="$user->file_id_card"
                :id="$user->id"
                name="file_id_card"
                class="pad_b10 pad_t20"
                title="Удостоверение личности"
            />

            <x-form.form-files
                :value="$user->file_criminal_record"
                :id="$user->id"
                name="file_criminal_record"
                class="pad_b10"
                title="Справка об отсутствии судимости"
            />

            <x-form.form-files
                :value="$user->file_dispensary"
                :id="$user->id"
                name="file_dispensary"
                class="pad_b10"
                title="Справка с псих. диспансера"
            />

            <x-form.form-files
                :value="$user->file_diploma_education"
                :id="$user->id"
                name="file_diploma_education"
                class="pad_b10"
                title="Диплом о высшем образовании"
            />

            <x-form.form-files
                :value="$user->file_accountant_certificate"
                :id="$user->id"
                name="file_accountant_certificate"
                class="pad_b10"
                title="Сертификат бухгалтера"
            />

            <x-form.form-files
                :value="$user->file_scientific_degrees"
                :id="$user->id"
                name="file_scientific_degrees"
                class="pad_b10"
                title="Научные степени"
            />


            @if($user->legal_entity)
                <x-form.form-files
                    :value="$user->file_legal_registration"
                    :id="$user->id"
                    name="file_legal_registration"
                    class="pad_b10"
                    title="Справка о регистрации компании"
                />

                <x-form.form-files
                    :value="$user->file_legal_regulation"
                    :id="$user->id"
                    name="file_legal_regulation"
                    class="pad_b10"
                    title="Устав"
                />

                <x-form.form-files
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
          </div>


</div>
</div>
