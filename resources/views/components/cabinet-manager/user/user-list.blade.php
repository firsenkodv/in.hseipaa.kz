@props([
    'items',
    'markDelete' => false,
])
<div class="cabinet__users_scroll">
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

            </div>

        </div>
        @forelse($items as $item)
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
            </div>
        @empty
            <div class="user_user-list-item u_teaser">
                Пользователей нет
            </div>
        @endforelse

        {{ $items->withQueryString()->links('pagination::default') }}

    </div>
</div>
