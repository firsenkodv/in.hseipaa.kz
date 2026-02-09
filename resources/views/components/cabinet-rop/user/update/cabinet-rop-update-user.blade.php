@props(
    ['item']
)
    <div class="cabinet-user-update_update_cabinet-user-update">

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <x-avatar.avatar-user :user="$item"
                                      :route="route('upload_rop-user_photo')"
                                      folder="users"
                                      :userid="$item->id"
                />

            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu_username">
                    <h1 class="h1">{{ $item->username }}</h1>
                    <p class="_subtitle">{{ config('site.constants.head_sales_department') }}</p>

                </div>
            </div>
        </div>


        <div class="cabinet_user_update_handel">
            <x-cabinet.update-user :user="$item" :route="route('rop_update_post_user')"/>
        </div>

    </div>

