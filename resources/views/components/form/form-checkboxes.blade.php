@props([
    'checkboxes' => [],
    'class' => '',
    'name' => ''

])
@if(count($checkboxes))
    <div class="checkbox__wrapper {{$class}}">
        @foreach($checkboxes as $checkbox)
            <div class="checkbox__flex">
                <div class="checkbox__left">
                    <div class="checkbox__title">{{ $checkbox['title'] }}</div>
                    <div class="checkbox__subtitle">{{ $checkbox['subtitle'] }}</div>
                </div>
                <div class="checkbox__right">
                 <x-form.form-checkbox checked="{{ $checkbox['checked'] }}" name="{{ $name }}" value="{{ $checkbox['id'] }}"/>
                </div>

            </div>
        @endforeach
    </div>
@endif

