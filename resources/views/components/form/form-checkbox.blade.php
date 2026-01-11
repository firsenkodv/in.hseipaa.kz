@props([
    'rand' =>  rand(100, 10000),
    'checked' => false,
    'name' => '',
    'value' => ''
])
<div class="checkbox-wrapper-3">
    <input type="checkbox" name="{{ $name }}" value="{{$value}}" id="cbx-{{ $rand }}" class="cbx-3" @if($checked) checked @endif/>
    <label for="cbx-{{ $rand }}" class="toggle"><span></span></label>
</div>
