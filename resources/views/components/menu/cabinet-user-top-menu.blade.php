<div class="cabinet-user_cabinet-user-top-menu">
<ul class="cabinet-user-top-menu">
    <li class="{{ active_linkMenu(asset(route('cabinet_user')))  }}">
        <a href="{{ route('cabinet_user') }}">Кабинет</a>
    </li>
    <li>
        <a href="#">Мой тариф</a>
    </li>
    <li>
        <a href="#">Услуги</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('cabinet_user_update')), 'find')  }}">
        <a href="{{ route('cabinet_user_update') }}">Настройки</a>
    </li>
</ul>
</div>
