@extends('layouts.layout')
<x-seo.meta
    title="{{ ($item->metatitle) ?? $item->title }}"
    description="{{ $item->description }}"
    keywords="{{ $item->keywords }}"
/>

@section('content')
    <main>

        <section>
            <div class="block block_content">

                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('company_item',  $category,  $item) }}</div>
                <div class="block_content__title"><h1 class="h1">{{ $item->title }}</h1>
                    @if($item->subtitle)
                        <p class="_subtitle">{{ $item->subtitle }}</p>
                    @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                        <x-menu.left-menu-component menu="companies"/>
                    </div>
                    <div class="block_content__right">
                        <x-content.content-component :content="$item" />

                    </div>
                </div>
                <x-content.content-faq-component :content="$item" />


            </div>
        </section>

    </main>
@endsection



