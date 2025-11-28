@if($video)
    <video controls width="100%" height="300">
        <source src="{{ $video }}" type="video/mp4"><!-- MP4 для Safari, IE9, iPhone, iPad, Android, и Windows Phone 7 -->
    </video>
@else
    <x-moonshine::collapse
        :label="'Нет загруженного видео -(('"
    >
    </x-moonshine::collapse>


@endif
