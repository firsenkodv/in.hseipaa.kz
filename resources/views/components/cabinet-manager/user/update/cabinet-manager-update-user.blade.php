@props([
    'item'
])
<div class="cabinet-user-update_update_cabinet-user-update">

    <div class="cabinet_user_personal__flex">
        <div class="cabinet_user_personal__left">
            <x-avatar.avatar-user
                :user="$item"
                :route="route('upload_manager-user_photo')"
                folder="users"
                :userid="$item->id"
            />
        </div>
        <div class="cabinet_user_personal__right">
            <div class="flex in-edit">
                <div class="cu_username left">
                    <h1 class="h1">{{ $item->username }}</h1>
                    <p class="_subtitle">
                        {{ isset($item->UserCity->title) ? $item->UserCity->title : 'Город не указан' }}
                    </p>
                    <p class="{{ \App\Enums\User\PublishedUserEnum::fromValue($item->published)->class() }}">
                        {{ $item->published_user }}
                    </p>
                </div>
                <div class="right">
                    <x-cabinet.message.to-user :item="$item" role="manager"/>
                </div>
            </div>
        </div>
    </div>

    <div class="cabinet_user_update_handel">
        <x-cabinet.update-user :user="$item" :route="route('manager_update_post_user')"/>
    </div>

</div>
