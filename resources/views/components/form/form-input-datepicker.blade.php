@props([
    'name' => '',
    'label' => '',
    'class' => '',
    'rand' => rand(100, 10000),
    'autocomplete' => 'off',
    'value' => '',
    'autofocus' => false,
    'required' => false
])
<div class="input-group app_input_group input-date-picker">
    <input data-date="{{ $value }}" class="input-group__input app_input_name {{ $class }}       @error($name) _error @enderror" type="text" placeholder="{{ $value }}" name="{{ $name }}" id="{{  $name . $rand }}" value="" autocomplete="{{ $autocomplete }}" {{ ($autofocus)? 'autofocus' : '' }}/>
    <label class="input-group__label @if($value) position_top @endif" for="{{  $name . $rand  }}">{{ $label }} {!! ($required) ?'<span>*</span>':'' !!}</label>
    <div class="input_error app_input_error">@error($name){{$message}}@enderror</div>
</div>
 {{--label - position_top--}}
