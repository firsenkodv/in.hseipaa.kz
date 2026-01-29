@props([
    'text' => ''
])

<div class="alert-danger"><a
        href="{{ route('cabinet_pricing') }}">{{ $text }}</a></div>
