<div class="enter_header-enter-component">
    <div class="enter_to_website">
        @if(!is_null($user))
            <a href="{{ route('cabinet_user') }}"><span>Кабинет</span><i></i></a>
        @else
            <a href="{{ route('login') }}"><span>Войти</span><i></i></a>
        @endif
    </div>
</div>
