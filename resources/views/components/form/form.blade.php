@props([
    'method' => 'post',
    'action' => '',
    'class' => '',
])

<form action="{{ $action }}" method="{{ $method }}" class="row_form_800" :class="{{ $class }}">
    @csrf
    @honeypot
    {{ $slot }}
</form>
