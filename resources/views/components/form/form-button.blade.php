@props([
    'url' => '/',
    'class' => '',
    'type' => ''
])
@if($type)
    <input class="btn btn-big app_form_button {{ $class }}" type="submit" value="{{ $slot }}" />
@else
    <div class="btn btn-big app_form_button {{ $class }}" data-url="{{ $url }}">{{ $slot }}</div>

@endif
