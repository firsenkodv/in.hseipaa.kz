@props([
    'type' => 'text',
    'name' => '',
    'label' => '',
    'class' => '',
    'rand' => rand(100, 10000),
    'autocomplete' => 'off',
    'value' => '',
    'autofocus' => false,
    'required' => false,
    'error' => '',
    'description' => '',
    'disabled' => false

])

@if($description)
    <div class="input_group__description">{!! $description !!}</div>
@endif
<div class="input-group app_input_group {{ ($disabled)?'display_none':'' }}">

    <input  class="input-group__input app_input_name {{ $class }}      @error(($error)?:$name) _error @enderror" type="{{ $type }}" placeholder="" name="{{ $name }}" id="{{  $name . $rand }}" value="{{ $value }}" autocomplete="{{ $autocomplete }}" {{ ($autofocus)? 'autofocus' : '' }}/>
    <label class="input-group__label" for="{{  $name . $rand  }}">{{ $label }} {!! ($required) ?'<span>*</span>':'' !!}</label>
    <div class="input_error app_input_error">@error(($error)?:$name){{$message}}@enderror</div>

</div>
