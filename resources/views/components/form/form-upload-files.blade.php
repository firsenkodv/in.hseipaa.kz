@props([
    'class'=> '',
    'title'=> '',
    'name' => '',
    'rand' => rand(100, 10000),

])

<div class="input-file app_input-file {{ $class }}"
     data-initialfiles='{{ json_encode($value) }}'>
    <div class="input-file__flex">
        <div class="input-file__left">
            <div class="input-file__title">{{ $title }}</div>
        </div>
        <div class="input-file__right">
            <div class="input_cover"></div>
            <div class="load_spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <div class="uploadedFiles">@if(count($value))
                    @foreach($value as $file)
                        <p data-strfile="{{$file['json_file']}}"><a href="{{ $file['url'] }}" download="" target="_blank"><i class="fa {{ $file['icon_class'] }}"></i></a><i class="delete_cross app_delete_cross" ></i></p>
                    @endforeach
                @endif</div>
            <label for="fileInput_{{$rand}}">+</label>
        </div>
    </div>

    <input type="file" id="fileInput_{{$rand}}" name="{{ $name }}" class="take__save app_take__save" multiple
           accept="image/*,.pdf,.docx"/>

</div>

