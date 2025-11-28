@extends('layouts.layout')
<x-seo.meta
    title="{{ ($subcategory->metatitle) ?? $subcategory->title }}"
    description="{{ $subcategory->description }}"
    keywords="{{ $subcategory->keywords }}"
/>

@section('content')
    <main>

        <section>
            <div class="block block_content">

 <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('useful_subcategory', $section, $category, $subcategory) }}</div>
                <div class="block_content__title"><h1 class="h1">{{ $subcategory->title }}</h1>
                    @if($subcategory->subtitle)
                        <p class="_subtitle">{{ $subcategory->subtitle }}</p>
                    @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                        <x-menu.left-menu-component menu="usefuls"/>
                    </div>
                    <div class="block_content__right">
                        <x-content.content-component :content="$subcategory" />
                    @if($items->isNotEmpty())
                        <div class="teaser">
                            @foreach($items as $item)


                                <x-content.teaser-component :content="$item" :url="route('useful_item', ['useful' => $section->slug ,'category_slug' => $category->slug,'subcategory_slug' => $subcategory->slug, 'item_slug' => $item->slug, ])" />

                            @endforeach
                        </div>
                            {{ $items->withQueryString()->links('pagination::default') }}

                        @endif
                    </div>
                </div>
                <x-content.content-faq-component :content="$subcategory" />


            </div>
        </section>

    </main>
@endsection




