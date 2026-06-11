@props([
    'items',
    'search' => '',
    'roles'  => [],
])
<div class="cabinet_manager_users cabinet__users_scroll">

    @if(in_array(route_name(), ['admin_users', 'admin_users_search']))
    <form method="GET" action="{{ route('admin_users_search') }}" class="manager_search_form">
        <div class="border_2_E0E0E0">
            <div class="row_form_800">
                <div class="row_form_800__left">
                    <input type="text" name="search" placeholder="Поиск по имени или e-mail..." value="{{ $search }}" autocomplete="off" maxlength="100">
                </div>
                <div class="row_form_800__right">
                    <button type="submit" class="btn btn-big"><span>Найти</span></button>
                </div>
            </div>
        </div>
        <div class="manager_search_roles">
            <label class="manager_search_roles__item">
                <x-form.form-checkbox name="roles[]" value="specialist" :checked="in_array('specialist', $roles)"/>
                <span>Специалист</span>
            </label>
            <label class="manager_search_roles__item">
                <x-form.form-checkbox name="roles[]" value="lecturer" :checked="in_array('lecturer', $roles)"/>
                <span>Лектор</span>
            </label>
            <label class="manager_search_roles__item">
                <x-form.form-checkbox name="roles[]" value="expert" :checked="in_array('expert', $roles)"/>
                <span>Эксперт</span>
            </label>
            @if($search || count($roles))
                <div class="manager_search_roles__spacer"></div>
                <a href="{{ route('admin_users') }}" class="btn btn-middle btn_grey">Сбросить</a>
            @endif
        </div>
    </form>
    @endif

    <div class="user_user-list cabinet__users">
        <div class="dashboardBox__title">
            <div class="user_user-list-item u_teaser u_teaser_label">
                <div class="avatar"></div>
                <div class="username">Имя</div>
                <div class="email">Email</div>
                <div class="options">Опции</div>
            </div>
        </div>

        @forelse($items as $item)
            <div class="flex c_flex">
                <a href="{{ route('admin_user', $item->id) }}" class="user_user-list-item u_teaser">
                    <div class="avatar" style="position:relative;">
                        <x-avatar.avatar
                            class="rm__avatar"
                            :avatar="$item->avatar"
                            :path="'users/' . $item->id . '/avatar/intervention'"
                            :woman="$item->woman"
                            :man="$item->man"
                            thumbnail="40x40"
                        />
                        @php
                            $unread = \Domain\CabinetMessage\ViewModels\CabinetMessageViewModel::make()->unreadCountFromUser($item->id);
                        @endphp
                        @if($unread > 0)
                            <span class="msg-badge">{{ $unread }}</span>
                        @endif
                    </div>
                    <div class="username">
                        @if($item->published)
                            <span class="blue" title="Опубликован">{{ $item->username }}</span>
                        @else
                            <span class="red" title="Не опубликован">{{ $item->username }}</span>
                        @endif
                    </div>
                    <div class="email">
                        {{ $item->email }}
                    </div>
                    <div class="options">
                        @if($item->UserSpecialist->count())
                            <x-cabinet.icons.specialist />
                        @endif
                        @if($item->UserLecturer->count())
                            <x-cabinet.icons.lecturer />
                        @endif
                        @if($item->UserExpert->count())
                            <x-cabinet.icons.expert />
                        @endif

                        @if($item->contracts_count > 0)
                            <span class="contract-stat" title="Всего договоров: {{ $item->contracts_count }}">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                                    <path d="M14 2v6h6"/>
                                </svg>
                                {{ $item->contracts_count }}
                            </span>

                            @if($item->contracts_signed_count > 0)
                                <span class="contract-stat contract-stat--signed" title="Подписано: {{ $item->contracts_signed_count }}">
                                    ✓&nbsp;{{ $item->contracts_signed_count }}
                                </span>
                            @endif

                            @if($item->contracts_unsigned_count > 0)
                                <span class="contract-stat contract-stat--unsigned" title="Ожидают подписания: {{ $item->contracts_unsigned_count }}">
                                    ⏳&nbsp;{{ $item->contracts_unsigned_count }}
                                </span>
                            @endif
                        @endif
                    </div>
                </a>
            </div>
        @empty
            <div class="user_user-list-item u_teaser">
                Пользователей нет
            </div>
        @endforelse

        {{ $items->withQueryString()->links('pagination::default') }}

    </div>
</div>
