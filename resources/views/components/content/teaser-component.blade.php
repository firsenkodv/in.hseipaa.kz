<div class="content_teaser-component desc">

    <a href="{{ $url }}" class="_teaser_title">{{ $content->title }}</a>
    @if($content->short_desc)
    <div class="_teaser_short_desc">{!!  $content->short_desc  !!}</div>
    @endif

    <div class="_teaser_category">


       {{-- parent_category и parent_subcategory объявляются в модели--}}
    @if(isset($content->parent_category))
            <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 _teaser_category__svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            <a href="{{ $content->parent_category->link  }}">{{ $content->parent_category->title  }}</a>
    @endif
    @if(isset($content->parent_subcategory))
            <a href="{{ $content->parent_subcategory->link  }}">{{ $content->parent_subcategory->title  }}</a>
        @endif
    </div>
</div>
