@if(!is_null($user))
    <div class="cabinet-user_cabinet-user-personal">

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

        <div class="cu__personal_wrap">
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Пол:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->UserSex))? $user->UserSex->title : ' - '}}
                    </div>
                </div>
            </div>

            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Электронная почта:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ $user->email }}
                    </div>
                </div>
            </div>

            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Телефон:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ format_phone($user->phone)  }}
                    </div>
                </div>
            </div>

            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Дата рождения:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ ($user->date_birthday) ?: ' - '}}
                    </div>
                </div>
            </div>

            @if($user->individual)
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>ИИН:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ ($user->iin) ?: ' - '}}
                        </div>
                    </div>
                </div>
            @endif

            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        <h2 class="h2">Адрес</h2>
                    </div>
                </div>
            </div>
            @if($user->UserCity)
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>Город:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ (isset($user->UserCity)) ? $user->UserCity->title : ' - '}}
                        </div>
                    </div>
                </div>
            @endif
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Индекс:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->address['json_address_post_index'])) ? $user->address['json_address_post_index'] : ' - '}}
                    </div>
                </div>
            </div>
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Область:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->address['json_address_area'])) ? $user->address['json_address_area'] : ' - '}}
                    </div>
                </div>
            </div>
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Улица:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->address['json_address_street'])) ? $user->address['json_address_street'] : ' - '}}
                    </div>
                </div>
            </div>
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Дом:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->address['json_address_house'])) ? $user->address['json_address_house'] : ' - '}}
                    </div>
                </div>
            </div>
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Кв./Офис.:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->address['json_address_office'])) ? $user->address['json_address_office'] : ' - '}}
                    </div>
                </div>
            </div>

            @if($user->individual)
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            <h2 class="h2">Место работы</h2>
                        </div>
                    </div>
                </div>
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>Наименование:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ $user->accountant_work ?  : ' - '}}
                        </div>
                    </div>
                </div>
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>Должность:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ $user->accountant_position ?  : ' - '}}
                        </div>
                    </div>
                </div>
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>Номер сертификата:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ $user->accountant_ticket ?  : ' - '}}
                        </div>
                    </div>
                </div>
            @endif
              @if($user->legal_entity)
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            <h2 class="h2">Место работы</h2>
                        </div>
                    </div>
                </div>
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>БИН:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ ($user->bin) ?: ' - '}}
                        </div>
                    </div>
                </div>
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>Наименование:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ $user->company ?  : ' - '}}
                        </div>
                    </div>
                </div>
                <div class="cabinet_user_personal__flex">
                    <div class="cabinet_user_personal__left">
                        <div class="cu__personal_label"><span>ФИО первого руководителя:</span></div>
                    </div>
                    <div class="cabinet_user_personal__right">
                        <div class="cu__personal_option">
                            {{ $user->position_boss ?  : ' - '}}
                        </div>
                    </div>
                </div>

            @endif


        </div>

    </div>
@endif
