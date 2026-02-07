@if(!is_null($user))
    <div class="cabinet-user_cabinet-user-personal">

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <x-avatar.avatar-user :user="$user" :route="route('upload_rop_photo')" />

            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu_username">
                    <h1 class="h1">{{ $user->username }}</h1>
                        <p class="_subtitle">{{ config('site.constants.head_sales_department') }}</p>
                </div>
            </div>
        </div>

        <div class="cu__personal_wrap">
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Телефон:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->phone))? format_phone($user->phone) : ' - '}}
                    </div>
                </div>
            </div>
            <div class="cabinet_user_personal__flex">
                <div class="cabinet_user_personal__left">
                    <div class="cu__personal_label"><span>Email:</span></div>
                </div>
                <div class="cabinet_user_personal__right">
                    <div class="cu__personal_option">
                        {{ (isset($user->email))? $user->email : ' - '}}
                    </div>
                </div>
            </div>

           </div>

    </div>
@endif
