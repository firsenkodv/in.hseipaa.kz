<div class="cabinet-user_cabinet-user-top-menu ">
    <ul class="cabinet-user-top-menu">
        <li class="{{ active_linkMenu(asset(route('cabinet_manager')))  }}">
            <a href="{{ route('cabinet_manager') }}">Кабинет</a>
        </li>

       <li class="{{ active_linkMenu(asset(route('manager_users')), 'find') }}">
            <a href="{{ route('manager_users') }}">Пользователи</a>
        </li>
        <li class="{{ active_linkMenu(asset(route('cabinet_update_personal_data_manager')), 'find')  }}">
            <a href="{{ route('cabinet_update_personal_data_manager') }}">Настройки</a>
        </li>
    </ul>
</div>
