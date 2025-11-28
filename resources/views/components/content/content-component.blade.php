@if($content->desc)
    <div class="content_content-component desc">
        @if(isset($content->short_desc))
            <div class="_short_desc bl_desc">{!!  $content->short_desc  !!}</div>
        @endif

            <div class="_desc bl_desc">{!!  $content->desc  !!}</div>

        @if($content->img2)
            <div class="_img2 bl_img2 relative">
                <img src="{{ Storage::url($content->img2) }}" alt="{{ $content->title }}" />
            </div>
        @endif

        @if($content->desc2)
            <div class="_desc2 bl_desc2">{!!  $content->desc2  !!}</div>
        @endif

        @if($content->files)
            <x-content.download-file-component :files="$content->files" />
        @endif

        @if($content->script_published)
           <div class="">{!! $content->script !!}</div>
        @endif



    </div>
@endif
