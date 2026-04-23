@props(['vacancyCount' => 0, 'archiveCount' => 0])

<div class="pad_t10 cabinet_rop-menu_left-menu">
    <ul class="_left_m nav">
        <li class="{{ active_linkMenu(route('my_vacancies'))  }}"><a href="{{ route('my_vacancies') }}">Вакансии
                <span class="_int">{{ $vacancyCount }}</span>
            </a>
        </li>
        <li class="{{ active_linkMenu(route('my_vacancy_create')) }}"><a href="{{ route('my_vacancy_create') }}">Создать вакансию</a></li>
        <li class="{{ active_linkMenu(route('my_vacancy_archive'), 'find') }}"><a href="{{ route('my_vacancy_archive') }}">Архив
                <span class="_int">{{ $archiveCount }}</span>
            </a>
        </li>
    </ul>
</div>
