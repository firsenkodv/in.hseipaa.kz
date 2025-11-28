@props([
    'class' => '',
    'k' => '',
])

<div data-tab="G_tab{{$k}}" class="G_tab{{$k}} {{ $active }} {{ $class }}">
{{ $slot }}
</div><!--.G_tab{{$k}}-->
