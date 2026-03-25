@props([
    'label' => '',
    'class' => '',
    'value' => '',
    'description' => '',

])

@if($description)
    <div class="input_group__description">{!! $description !!}</div>
@endif
<div class="input-group lab ">

    <div class="input-group__input ">
        <div class="lab__value {{ $class }}">{{ $value }}</div>
    </div>

    <label class="input-group__label">{{ $label }}</label>

</div>

