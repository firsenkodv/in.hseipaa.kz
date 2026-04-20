@props(['my' => false])

<div class="hh_menu">
    @if($my)
        <a class="{{ active_linkMenu(asset(route('my_vacancies')), 'find') }}" href="{{ route('my_vacancies') }}">Мои вакансии</a>
        <a class="{{ active_linkMenu(asset(route('my_resumes')), 'find') }}" href="{{ route('my_resumes') }}">Мои резюме</a>
    @else
        <a class="{{ active_linkMenu(asset(route('vacancies')), 'find') }}" href="{{ route('vacancies') }}">Вакансии</a>
        <a class="{{ active_linkMenu(asset(route('resumes')), 'find') }}" href="{{ route('resumes') }}">Резюме</a>
    @endif
</div>
