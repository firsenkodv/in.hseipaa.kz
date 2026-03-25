@props([
    'url' => '/',
    'class' => '',
    'type' => '',
    'id' => '',
])
@if($type)
    <input {{($id)?"id=$id":''}} class="btn  {{ $class }}" type="{{ $type }}" value="{{ $slot }}" />
@else
    <a href="{{ $url }}" class="btn  {{ $class }}">{{ $slot }}</a>
@endif

