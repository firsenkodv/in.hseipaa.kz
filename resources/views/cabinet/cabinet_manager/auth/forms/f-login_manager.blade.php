<x-form.form
    title="{{ config('site.constants.enter_for_manager') }}"
    subtitle="{{ config('site.constants.for_managing_users') }}"
    action="{{ route('manager_login_handle') }}"
    method="POST"
>

    <div class="text_input">
        <x-form.form-input
            label="Email"
            type="email"
            name="email"
            required="{{ true }}"
            value="{{ ( session('m_email') ) ?  : '' }}"
        />

    </div>
    <div class="text_input">
        <x-form.form-input
            label="Password"
            type="password"
            name="password"
            required="{{ true }}"
            value="{{ ( session('m_password') ) ?  : '' }}"
        />
    </div>


        <div class="pageLogin__slotButtons slotButtons">
            <div class="slotButtons__flex">

                <div class="slotButtons__right">
                    <!--Вход в систему -->
                    <x-form.form-button class="w_100_important" type="submit">{{ config('site.constants.enter')}}</x-form.form-button>

                </div>
            </div>

        </div>
</x-form.form>
