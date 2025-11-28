@extends('layouts.layout')
<x-seo.meta
    title="{{ ($section->metatitle) ?? $section->title }}"
    description="{{ $section->description }}"
    keywords="{{ $section->keywords }}"
/>

@section('content')
    <main>

        <section>
            <div class="block block_content">
                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('useful_section', $section) }}</div>
                <div class="block_content__title"><h1 class="h1">{{ $section->title }}</h1>
                    @if($section->subtitle)
                        <p class="_subtitle">{{ $section->subtitle }}</p>
                    @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                       <x-menu.left-menu-component menu="usefuls"/>
                    </div>
                    <div class="block_content__right">
                        <x-content.content-component :content="$section" />

                    @if($categories->isNotEmpty())
                        <div class="teaser">
                            @foreach($categories as $category)

                             <x-content.teaser-component :content="$category" :url="route('useful_category', ['useful' => $section->slug ,'category_slug' => $category->slug])" />

                            @endforeach

                        </div>
                                {{ $categories->withQueryString()->links('pagination::default') }}

                        @endif
                    </div>
                </div>

                <x-content.content-faq-component :content="$section" />

            </div>
        </section>

    </main>
@endsection



