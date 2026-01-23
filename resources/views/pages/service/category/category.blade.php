@extends('layouts.layout')
<x-seo.meta
    title="{{ ($category->metatitle) ?? $category->title }}"
    description="{{ $category->description }}"
    keywords="{{ $category->keywords }}"
/>

@section('content')

    <main>

        <section>
            <div class="block block_content">

 <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('service_category', $section, $category) }}</div>
                <div class="block_content__title"><h1 class="h1">{{ $category->title }}</h1>
                    @if($category->subtitle)
                        <p class="_subtitle">{{ $category->subtitle }}</p>
                    @endif
                </div>

                <div class="block_content__flex">
                    <div class="block_content__left">
                        <x-menu.left-menu-component menu="services"/>
                    </div>
                    <div class="block_content__right">

                        <x-content.content-other-component  :content="$category"  />

                        <x-content.content-component :content="$category" />

                        <x-checking-counterparty.checking-counterparty-component :counterparty="$category->checking_counterparty" />

                        <x-content.content-tarif-component :content="$category" />

                    @if($items->isNotEmpty())
                        <div class="teaser">
                            @foreach($items as $item)

                                <x-content.teaser-component :content="$item" :url="route('service_item', ['service' => $section->slug ,'category_slug' => $category->slug,'item_slug' => $item->slug ])" />

                            @endforeach
                            {{ $items->withQueryString()->links('pagination::default') }}
                        </div>
                        @endif
                    </div>
                </div>

                <x-content.content-faq-component :content="$category" />

            </div>
        </section>

    </main>
@endsection




