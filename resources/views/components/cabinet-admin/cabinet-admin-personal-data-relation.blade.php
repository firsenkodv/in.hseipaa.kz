<div class="cabinet-user_cabinet-user-personal-data-relation">

    <x-cabinet-admin.cabinet-admin-info />

    <div class="block_action">
        <a href="#"
           class="btn btn-big btn-green open-fancybox"
           data-form="admin_user_create">
            <i class="fa fa-user-plus" style="margin-right: 10px;"></i>
            <span>Создать пользователя</span>
        </a>
    </div>

    <div class="block_exit">
        <x-form action="{{ route('logout_admin') }}">
            <x-form.form-button type="submit">
                Выход
            </x-form.form-button>
        </x-form>
    </div>

</div>
