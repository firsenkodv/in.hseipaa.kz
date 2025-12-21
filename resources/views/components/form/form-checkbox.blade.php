@props([
    'rand' =>  rand(1, 10000),
    'checked' => false
])
<div class="checkbox-wrapper-3">
    <input type="checkbox" id="cbx-{{ $rand }}" class="cbx-3" @if($checked) checked @endif/>
    <label for="cbx-{{ $rand }}" class="toggle"><span></span></label>
</div>
