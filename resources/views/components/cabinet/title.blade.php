@props([
    'title',
    'subtitle' => null,
    'mini' => null,
])
<div class="block_content__title"><h1 class="h1">{{ $title }}</h1>
    <p class="_subtitle">{{ $subtitle }} <span class="_mini">{{ ($mini)??'' }}</span></p>
</div>
