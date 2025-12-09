@props([
    'url' => '/',
    'class' => ''
])
<div class="btn btn-big app_form_button {{ $class }}" data-url="{{ $url }}">{{ $slot }}</div>
