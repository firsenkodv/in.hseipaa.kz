@props(['resumeCount' => 0])

<div class="pad_t10 cabinet_rop-menu_left-menu">
    <ul class="_left_m nav">
        <li class="{{ active_linkMenu(route('my_resumes'))  }}"><a href="{{ route('my_resumes') }}">Резюме
                <span class="_int">{{ $resumeCount }}</span>
            </a>
        </li>
        <li class="{{ active_linkMenu(route('my_resume_create')) }}"><a href="{{ route('my_resume_create') }}">Создать резюме</a></li>

        <li class=""><a href="#">Архив
                <span class="_int">0</span>
            </a>
        </li>
    </ul>
</div>
