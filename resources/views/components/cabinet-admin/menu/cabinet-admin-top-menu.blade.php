<div class="cabinet-user_cabinet-user-top-menu cabinet-rop_cabinet-rop-top-menu">
    <ul class="cabinet-user-top-menu">
        <li class="{{ active_linkMenu(asset(route('cabinet_admin'))) }}">
            <a href="{{ route('cabinet_admin') }}">Кабинет</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('admin_users')), 'find') }}">
            <a href="{{ route('admin_users') }}">Пользователи</a>
        </li>
{{--        <li class="{{ active_linkMenu(asset(route('admin_trainings')), 'find') }}">
            <a href="{{ route('admin_trainings') }}">Дисциплины</a>
        </li>--}}
        <li class="{{ active_linkMenu(asset(route('admin_contracts')), 'find') }}">
            <a href="{{ route('admin_contracts') }}">Договоры</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('cabinet_update_personal_data_admin')), 'find') }}">
            <a href="{{ route('cabinet_update_personal_data_admin') }}">Настройки</a>
        </li>
    </ul>
</div>
