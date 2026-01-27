@if($content->desc)
    <div class="content_content-component desc">

        @if(isset($content->short_desc))
            <div class="_short_desc bl_desc pad_b0_important">{!!  $content->short_desc  !!}</div>
        @endif

        @if($content->show['show_subscription'] == 1 or $tariff_has_been_paid)
            <hr>
            <div class="_desc bl_desc">{!!  $content->desc  !!}</div>

            @if($content->img2)
                <div class="_img2 bl_img2 relative">
                    <img src="{{ Storage::url($content->img2) }}" alt="{{ $content->title }}"/>
                </div>
            @endif

            @if($content->desc2)
                <div class="_desc2 bl_desc2">{!!  $content->desc2  !!}</div>
            @endif

            @if($content->files)
                <x-content.download-file-component :files="$content->files"/>
            @endif

            @else

        @endif
<div class="alert-danger"><a href="{{ route('cabinet_pricing') }}">{{ config2('moonshine.setting.you_need_subscribe') }}</a></div>
    </div>
@endif

@if($content->script_published)
    <div class="">{!! $content->script !!}</div>
@endif
