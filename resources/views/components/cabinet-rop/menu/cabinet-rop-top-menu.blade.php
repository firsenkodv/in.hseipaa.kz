<div class="cabinet-user_cabinet-user-top-menu cabinet-rop_cabinet-rop-top-menu">
    <ul class="cabinet-user-top-menu">
        <li class="{{ active_linkMenu(asset(route('cabinet_rop')))  }}">
            <a href="{{ route('cabinet_rop') }}">Кабинет</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('rop_managers')), 'find') }}">
            <a href="{{ route('rop_managers') }}">Мои менеджеры</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('rop_users')), 'find') }}">
            <a href="{{ route('rop_users') }}">Пользователи</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('cabinet_update_personal_data_rop')), 'find')  }}">
            <a href="{{ route('cabinet_update_personal_data_rop') }}">Настройки</a>
        </li>
    </ul>
</div>
