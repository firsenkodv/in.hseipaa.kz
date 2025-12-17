@if(!is_null($user))

<div class="cabinet-user_cabinet-user-personal">

<div class="cabinet_user_personal__flex">
    <div class="cabinet_user_personal__left">
        <x-avatar.avatar-user :user="$user" />

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



</div>
@endif
