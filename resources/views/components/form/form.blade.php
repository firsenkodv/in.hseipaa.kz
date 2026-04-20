@props([
    'method' => 'post',
    'action' => '',
    'class' => '',
    'put' => false,
    'enctype' => ''
])

<form action="{{ $action }}" method="{{ $method }}" class="row_form_800 {{ $class }} " @if($enctype) enctype="{{ $enctype }}" @endif>
    @if(strtoupper($method) != "GET") @csrf    @honeypot @endif
    @if($put)
       @method('PUT')
    @endif

    {{ $slot }}
</form>
