<div class="cabinet-user_cabinet-user-personal-data-relation">
    <div class="cabinet_radius12_fff cabinet_rop-menu_left-menu">
        <ul class="_left_m nav">
            <li class="{{ active_linkMenu(route('rop_hh_vacancies'), 'find') }}">
                <a href="{{ route('rop_hh_vacancies') }}">Вакансии
                    <span class="_int">{{ $vacancyCount }}</span>
                </a>
            </li>
            <li class="{{ active_linkMenu(route('rop_hh_vacancies_moder'), 'find') }}">
                <a href="{{ route('rop_hh_vacancies_moder') }}">Вакансии на модерации
                    <span class="_int">{{ $vacancyModerationCount }}</span>
                </a>
            </li>
            <li class="{{ active_linkMenu(route('rop_hh_resumes'), 'find') }}">
                <a href="{{ route('rop_hh_resumes') }}">Резюме
                    <span class="_int">{{ $resumeCount }}</span>
                </a>
            </li>
            <li class="{{ active_linkMenu(route('rop_hh_resumes_moder'), 'find') }}">
                <a href="{{ route('rop_hh_resumes_moder') }}">Резюме на модерации
                    <span class="_int">{{ $resumeModerationCount }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
