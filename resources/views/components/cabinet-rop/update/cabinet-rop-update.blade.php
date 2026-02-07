@if(!is_null($user))

    <div class="cabinet-user-update_update_cabinet-user-update">

        <div class="cabinet_user_personal__flex">
            <div class="cabinet_user_personal__left">
                <x-avatar.avatar-user :user="$user" :route="route('upload_rop_photo')" folder="rops"/>
            </div>
            <div class="cabinet_user_personal__right">
                <div class="cu_username">
                    <h1 class="h1">{{ $user->username }}</h1>
                    <p class="_subtitle">{{ config('site.constants.head_sales_department') }}</p>

                </div>
            </div>
        </div>
        <div class="cabinet_user_update_handel">

            <x-form.form
                method="POST"
                :put="true"
                :action="route('cabinet_update_post_personal_data_rop')"
            >
                <h2 class="h2 pad_b32">Личные данные</h2>
                <div class="cu_row_50">
                    <div class="cu__col">
                        <x-form.form-input
                            name="username"
                            type="text"
                            label="ФИО"
                            value="{!!  (old('username'))?: ($user->username?:'') !!}"
                            autofocus="{{ true }}"
                            required="{{ true }}"

                        />
                    </div>
                    <div class="cu__col">
                        <x-form.form-input
                            name="phone"
                            type="tel"
                            label="Телефон"
                            value="{{ (old('phone'))?: ($user->phone?:'') }}"
                            class="imask"

                        />
                    </div>
                </div>

                        <x-form.form-input
                            name="email"
                            type="email"
                            label="Email"
                            value="{{ (old('email'))?: ($user->email?:'') }}"
                        />



                <div class="row_form_800__right">
                    <button type="submit" class="btn btn-big"><span>{{ config('site.constants.cabinet_edit') }}</span></button>
                </div>

            </x-form.form>

        </div>

    </div>
@endif
