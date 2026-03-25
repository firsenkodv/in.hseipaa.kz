@props([
    'id'=> false,
    'class'=> '',
    'title'=> '',
    'name' => '',
])

<div class="input-file {{ $class }}">
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
                        <p data-strfile="{{$file['json_file']}}"><a href="{{ $file['url'] }}" download="" target="_blank"><i class="fa {{ $file['icon_class'] }}"></i></a></p>
                    @endforeach
                @endif</div>
        </div>
    </div>


</div>

