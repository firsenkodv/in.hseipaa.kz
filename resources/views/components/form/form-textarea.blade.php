@props([

    'name' => '',
    'label' => '',
    'class' => '',
    'rand' => rand(1, 10000),
    'autocomplete' => 'off',
    'value' => '',
    'autofocus' => false,
    'required' => false,
    'error' => '',
    'description' => ''

])


<div class="input-group app_input_group">

    <textarea  class="input-group__input app_input_name {{ $class }}      @error(($error)?:$name) _error @enderror"  placeholder="" name="{{ $name }}" id="{{  $name . $rand }}"  autocomplete="{{ $autocomplete }}" {{ ($autofocus)? 'autofocus' : '' }}>{{ $value }}</textarea>
    <label class="input-group__label" for="{{  $name . $rand  }}">{{ $label }} {!! ($required) ?'<span>*</span>':'' !!}</label>
    <div class="input_error app_input_error">@error(($error)?:$name){{$message}}@enderror</div>

</div>
