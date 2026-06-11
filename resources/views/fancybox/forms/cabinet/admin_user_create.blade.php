<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Пользователь успешно создан. Данные для входа отправлены на email."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b18_important">
            <div class="form_title__h1">Создать пользователя</div>
        </div>

        <div class="form_data app_form_data pad_b18_important">

            <x-form.form-input
                name="username"
                type="text"
                label="Имя"
                :required="true"
                :autofocus="true"
            />

            <x-form.form-input
                name="company"
                type="text"
                label="Компания"
            />

            <x-form.form-input
                name="email"
                type="email"
                label="Email"
                :required="true"
            />

            <x-form.form-input
                name="password"
                type="password"
                label="Пароль"
                :required="true"
            />

            <x-form.form-input
                name="password_confirmation"
                type="password"
                label="Повторите пароль"
                :required="true"
            />

        </div>

        <div class="input-button">
            <x-form.form-button url="admin_user_create">
                Создать пользователя
            </x-form.form-button>
        </div>

    </div>
</div>
