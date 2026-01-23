@props([
    'items' => [],
    'route'=> '#',
    'user' => null
    ])
<div class="content_content-registry-component desc">

    @if(count($items))

        @foreach($items as $item)
        <x-content.registry.teaser :item="$item" :route="$route" :user="$user"/>
        @endforeach

    @else
        <div class="registry__item">
            <div class="registry__flex">
                {{ config('site.constants.search_registry_empty') }}
            </div>
        </div>

    @endif
</div>
