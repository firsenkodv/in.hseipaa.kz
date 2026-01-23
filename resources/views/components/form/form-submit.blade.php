@props([
    'url' => '/',
    'class' => '',
    'type' => ''
])
@if($type)
    <input class="btn  {{ $class }}" type="{{ $type }}" value="{{ $slot }}" />
@else
    <a href="{{ $url }}" class="btn  {{ $class }}">{{ $slot }}</a>
@endif

