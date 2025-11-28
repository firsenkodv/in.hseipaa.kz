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
 <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('useful_category', $section, $category) }}</div>
                <div class="block_content__title"><h1 class="h1">{{ $category->title }}</h1>

                @if($category->subtitle)
                        <p class="_subtitle">{{ $category->subtitle }}</p>
                @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                        <x-menu.left-menu-component menu="usefuls"/>
                    </div>
                    <div class="block_content__right">

                        <x-content.content-component :content="$category" />


                        @if($subcategories->isNotEmpty())
                            <div class="teaser">
                            @foreach($subcategories as $subcategory)

                                <x-content.teaser-component :content="$subcategory" :url=" route('useful_subcategory', ['useful' => $section->slug ,'category_slug' => $category->slug,'subcategory_slug' => $subcategory->slug ])" />

                            @endforeach
                            </div>
                            {{ $subcategories->withQueryString()->links('pagination::default') }}

                        @endif
                    </div>
                </div>
                <x-content.content-faq-component :content="$category" />


            </div>
        </section>

    </main>
@endsection




