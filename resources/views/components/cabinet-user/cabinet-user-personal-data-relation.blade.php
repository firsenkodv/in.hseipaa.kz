@props([
'relation' => true
])
<div class="cabinet-user_cabinet-user-personal-data-relation">

    <div class="block_published">

        @if($user->published)
            <div class="__on">{!!   config('site.constants.published_on') !!}</div>
        @else
            <div class="__off">{!!   config('site.constants.published_off') !!}</div>
        @endif
    </div>
    @if($relation)
        <div class="block_grey">
            <div class="__head">
                Лектор
            </div>
            <div class="__body">
                @if(count($user->UserLecturer))

                    @foreach($user->UserLecturer as $lecturer)
                        <div class="__body__option">
                            {{ $lecturer->title }}
                        </div>
                    @endforeach
                @else
                    Выбор в настройках
                @endif
            </div>
        </div>
        <div class="block_green">
            <div class="__head">
                Эксперт
            </div>
            <div class="__body">
                @if(count($user->UserExpert))

                    @foreach($user->UserExpert as $expert)
                        <div class="__body__option">
                            {{ $expert->title }}
                        </div>
                    @endforeach
                @else
                    Выбор в настройках
                @endif
            </div>
        </div>
    @endif


    <div class="block_exit">
        <x-form action="{{ route('logout') }}">
            <x-form.form-button
                type="submit">
                Выход
            </x-form.form-button>
        </x-form>
    </div>

</div>
