<div class="cabinet-user_cabinet-user-top-menu">
<ul class="cabinet-user-top-menu">
    <li class="{{ active_linkMenu(asset(route('cabinet_user')))  }}">
        <a href="{{ route('cabinet_user') }}">Кабинет</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('cabinet_service'), 'find'))  }}">
        <a href="{{ route('cabinet_service') }}">Услуги</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('cabinet_pricing'), 'find'))  }}">
        <a href="{{ route('cabinet_pricing') }}">Мой тариф</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('cabinet_user_messages')), 'find')  }}">
        <a href="{{ route('cabinet_user_messages') }}">
            Сообщения
            @if($unread > 0)
                <span class="msg-badge">{{ $unread }}</span>
            @endif
        </a>
    </li>


    <li class="{{ active_linkMenu(asset(route('my_vacancies')), 'find')  }}">
        <a href="{{ route('my_vacancies') }}">Мои вакансии</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('my_resumes')), 'find')  }}">
        <a href="{{ route('my_resumes') }}">Мои резюме</a>
    </li>



    <li class="{{ active_linkMenu(asset(route('vacancies')), 'find')  }}">
        <a href="{{ route('vacancies') }}">Вакансии</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('resumes')), 'find')  }}">
        <a href="{{ route('resumes') }}">Резюме</a>
    </li>
    <li class="{{ active_linkMenu(asset(route('cabinet_user_update')), 'find')  }}">
        <a href="{{ route('cabinet_user_update') }}">Настройки</a>
    </li>
</ul>
</div>
