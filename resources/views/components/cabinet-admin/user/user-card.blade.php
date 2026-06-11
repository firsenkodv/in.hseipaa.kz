@props(['user'])

<div class="cabinet-user_cabinet-user-personal">

    <div class="cabinet_user_personal__flex">
        <div class="cabinet_user_personal__left">
            <x-avatar.avatar-user
                :user="$user"
                :route="route('admin_user', $user->id)"
                folder="users"
                :userid="$user->id"
                :readonly="true"
                :woman="$user->woman"
                :man="$user->man"
            />
        </div>
        <div class="cabinet_user_personal__right">
            <div class="cu_username">
                <h1 class="h1">{{ $user->username }}</h1>
            </div>
        </div>
    </div>

    <div class="cu__personal_wrap">

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <div class="cu__personal_label"><span>Email:</span></div>
            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu__personal_option">{{ $user->email ?: '-' }}</div>
            </div>
        </div>

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <div class="cu__personal_label"><span>Телефон:</span></div>
            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu__personal_option">
                    {{ $user->phone ? format_phone($user->phone) : '-' }}
                </div>
            </div>
        </div>

        @if($user->UserSpecialist->count() || $user->UserLecturer->count() || $user->UserExpert->count())
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Роли:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option options">
                        @if($user->UserSpecialist->count())
                            <x-cabinet.icons.specialist />
                        @endif
                        @if($user->UserLecturer->count())
                            <x-cabinet.icons.lecturer />
                        @endif
                        @if($user->UserExpert->count())
                            <x-cabinet.icons.expert />
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>

    <div class="user-card-cta">
        <div class="user-card-cta__card">

            {{-- Декоративные круги --}}
            <div class="user-card-cta__deco user-card-cta__deco--1"></div>
            <div class="user-card-cta__deco user-card-cta__deco--2"></div>
            <div class="user-card-cta__deco user-card-cta__deco--3"></div>
            <div class="user-card-cta__deco user-card-cta__deco--4"></div>
            <div class="user-card-cta__deco user-card-cta__deco--5"></div>

            {{-- Иконка --}}
            <div class="user-card-cta__icon">
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5h13l7 7v19H9V5z" fill="rgba(255,255,255,0.12)" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                    <path d="M22 5v7h7" stroke="white" stroke-width="1.6" stroke-linejoin="round"/>
                    <line x1="13" y1="17" x2="24" y2="17" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="13" y1="21" x2="24" y2="21" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="13" y1="25" x2="19" y2="25" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="27" cy="28" r="4.5" fill="#EF533F" stroke="white" stroke-width="1.4"/>
                    <path d="M25.4 28.2l1 1 2.2-2" stroke="white" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            {{-- Бейдж --}}
            <div class="user-card-cta__badge">Требуется действие</div>

            {{-- Заголовок --}}
            <div class="user-card-cta__title">Оформление договора</div>

            {{-- Подзаголовок --}}
            <div class="user-card-cta__subtitle">
                Создайте договор и отправьте его пользователю на подписание
            </div>

            {{-- Линия-акцент --}}
            <div class="user-card-cta__line"></div>

            {{-- Кнопка --}}
            <a href="#"
               class="user-card-cta__btn open-fancybox"
               data-form="admin_contract_create"
               data-transfer='{"user_id": {{ $user->id }}}'>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M12 5v14M5 12h14" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
                Создать договор
            </a>

            {{-- Инфо-строка --}}
            <div class="user-card-cta__info">
                <div class="user-card-cta__info-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" stroke="#095C9A" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M14 2v6h6" stroke="#095C9A" stroke-width="1.8" stroke-linejoin="round"/>
                    </svg>
                    <span>Документ</span>
                </div>
                <div class="user-card-cta__sep"></div>
                <div class="user-card-cta__info-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#095C9A" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M22 6l-10 7L2 6" stroke="#095C9A" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Отправка</span>
                </div>
                <div class="user-card-cta__sep"></div>
                <div class="user-card-cta__info-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                        <path d="M20 6L9 17l-5-5" stroke="#095C9A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Подписание</span>
                </div>
            </div>

        </div>
    </div>

</div>
