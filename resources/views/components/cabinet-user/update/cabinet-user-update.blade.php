@if(!is_null($user))
    <div class="cabinet-user-update_update_cabinet-user-update">

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

        <div class="cabinet_user_update_handel">
          <x-cabinet.update-user :user="$user" :route="route('cabinet_user_update_handel')"/>
        </div>

    </div>
@endif
