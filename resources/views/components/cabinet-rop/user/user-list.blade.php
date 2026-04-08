@props([
    'managers',
    'selected',
    'value',
    'markDelete' => false,
])
<div class="cabinet__users_scroll">
    <div class="user_user-list cabinet__users">
        <div class="dashboardBox__title">
            <x-form.form-select-cabinet
                name="Выберите менеджера"
                :options="$managers"
                :selected="$selected"
                :value="$value"
                field_name="manager"
                class="app_select"
            />
            <div class="cu_row_30 cu_row">
                <div class="cu__col">
                    <x-form.form-submit
                        type="button"
                        class="btn-big"
                        id="app_show_users"
                    >Показать пользователей
                    </x-form.form-submit>
                </div>

                <div class="cu__col">
                    <x-form.form-submit
                        type="button"
                        class="btn-big btn_green"
                        id="app_change_manager"
                    >Закрепить за менеджером
                    </x-form.form-submit>
                </div>

                <div class="cu__col">
                    <x-form.form-submit
                        class="btn-big btn_white"
                        :url="route('rop_users')"
                    >Сбросить
                    </x-form.form-submit>
                </div>
            </div>
            <br>
            <div class="flex">
                <div class="__checkbox">
                    <input class="checkbox-flip check_all" data-chance="" type="checkbox" id="check_all">
                    <label for="check_all"><span></span></label>
                </div>
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

            </div>

        </div>
        @foreach($items as $item)
            <div class="flex c_flex">
                <div class="__checkbox">
                    <input class="checkbox-flip checkbox_change" data-checkbox="{{ $item->id }}" value="{{ $item->id }}"
                           type="checkbox" id="check_{{$item->id}}"/>
                    <label for="check_{{$item->id}}"><span></span></label>
                </div>

                <a href="{{route('rop_update_user', $item->id)}}" class="user_user-list-item u_teaser">
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
                @if($markDelete and (route_name() == 'rop_no_published_users'))
                    <x-form.form
                        method="POST"
                        :action="route('rop_mark_user_delete', $item->id)"
                        class="icon_delete"
                    >
                        <button type="submit" title="На удаление" style="background:none;border:none;cursor:pointer;padding:0;color:inherit;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </x-form.form>
                @endif
            </div>
        @endforeach

        {{ $items->withQueryString()->links('pagination::default') }}

    </div>
</div>
