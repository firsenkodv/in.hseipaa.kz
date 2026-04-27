@props([
    'items',
    'markDelete' => false,
    'search'     => '',
    'roles'      => [],
])
<div class="cabinet_manager_users cabinet__users_scroll">

    @if(in_array(route_name(), ['manager_users', 'manager_users_search']))
    <form method="GET" action="{{ route('manager_users_search') }}" class="manager_search_form">
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
                <a href="{{ route('manager_users') }}" class="btn btn-middle btn_grey">Сбросить</a>
            @endif
        </div>
    </form>
    @endif

    <div class="user_user-list cabinet__users">
        <div class="dashboardBox__title">
            <div class="flex">
                <div class="user_user-list-item u_teaser u_teaser_label">
                    <div class="avatar">

                    </div>
                    <div class="username">
                        Имя
                    </div>
                    <div class="email">
                        Email
                    </div>
                    <div class="options">
                        Опции
                    </div>
                </div>
                <button class="u_teaser_toggle js-user-details-toggle-all" type="button" title="Раскрыть все">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

            </div>

        </div>
        @forelse($items as $item)
            <div class="u_teaser_wrap">
                <div class="flex c_flex">
                    <a href="{{route('manager_update_user', $item->id)}}" class="user_user-list-item u_teaser">
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
                                <span class="blue" title="Опубликован">{{$item->username}}</span>
                            @else
                                <span class="red" title="Не опубликован">{{$item->username}}</span>
                            @endif
                        </div>
                        <div class="email">
                            {{$item->email}}
                        </div>
                        <div class="options">
                            @if($item->UserSpecialist->count())
                                <x-cabinet.icons.specialist />
                            @endif
                            @if($item->UserLecturer->count())
                                <x-cabinet.icons.lecturer />
                            @endif
                            @if($item->UserExpert->count())
                                <x-cabinet.icons.expert/>
                            @endif
                        </div>
                    </a>
                    @if($markDelete and (route_name() == 'manager_no_published_users'))
                        <x-form.form
                            method="POST"
                            :action="route('manager_mark_user_delete', $item->id)"
                            class="icon_delete"
                        >
                            <button type="submit" title="На удаление" style="background:none;border:none;cursor:pointer;padding:0;color:inherit;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </x-form.form>
                    @endif
                    <button class="u_teaser_toggle js-user-details-toggle" type="button" title="Подробнее">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>

                <div class="u_teaser_details" style="display:none;">
                    <div class="u_teaser_details__avatar"></div>
                    <div class="u_teaser_details__username">
                        {{ $item->phone ? format_phone($item->phone) : '—' }}
                    </div>
                    <div class="u_teaser_details__email">
                        <a href="#" class="open-fancybox u_teaser_tarif_link {{ $item->Tarif ? 'tarif-plan--' . $item->Tarif->slug : 'tarif-plan--none' }}" data-form="manager_set_tarif" data-transfer='{"user_id": {{ $item->id }}}'>
                            @if($item->Tarif)
                                {{ $item->Tarif->title }}
                                @if($item->tarif_expires_at)
                                    &nbsp;—&nbsp;<span class="{{ $item->hasTarif ? 'tarif-active' : 'tarif-expired' }}">до {{ $item->tarif_expires_at->format('d.m.Y') }}</span>
                                @endif
                            @else
                                <span class="tarif-none">Тариф не подключён</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="user_user-list-item u_teaser">
                Пользователей нет
            </div>
        @endforelse

        {{ $items->withQueryString()->links('pagination::default') }}

    </div>
</div>
