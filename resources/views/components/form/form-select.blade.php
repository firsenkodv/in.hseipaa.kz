@props([
    'title' => '',
    'name' => '',
    'label' => '',
    'class' => '',
    'rand' => rand(1, 10000),
    'value' => '',
    'options' => [],
    'selected' => '',
    'required' => false

])
@if(count($options))
<div class="input-group app_select_group">
    @if($title)
        <h4 class="_group_title">{{ $title }}</h4>
    @endif
    <div class="select-box">

        <div class="options-container scroll-block">

          @foreach($options as $k=>$option)
                <div class="option">
                    <input type="radio" class="radio" id="{{'select_service' . $k . $rand}}" name="select_service" />
                    <label for="{{'select_service' . $k . $rand }}">{{ $option['json_text'] }}</label>
                </div>
            @endforeach

        </div>

        <div class="selected {{ ($selected)?'active':''  }}" data-select="{{ $name }}">{{ ($selected)?:$name }} {!! ($required) ?'<span>*</span>':'' !!}</div>
        <div class="app_input_error input_error"></div>


        <div class="search-box">
            <input type="text" placeholder="Поиск..." />
        </div>

    </div>
</div>
@endif

