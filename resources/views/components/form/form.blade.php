@props([
    'method' => 'post',
    'action' => '',
    'class' => '',
    'put' => false
])

<form action="{{ $action }}" method="{{ $method }}" class="row_form_800" :class="{{ $class }}">
    @csrf
    @if($put)
       @method('PUT')
    @endif
    @honeypot
    {{ $slot }}
</form>
