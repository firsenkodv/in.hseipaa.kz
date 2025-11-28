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

                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('tax_calendar', $item) }}</div>
                <div class="block_content__title"><h1 class="h1">{{ $item->title }}</h1>
                    @if($item->subtitle)
                        <p class="_subtitle">{{ $item->subtitle }}</p>
                    @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                       <x-tax.tax-menu-component />
                    </div>
                    <div class="block_content__right">
                        <x-tax.tax-content-component :item="$item" />
                    </div>
                </div>
                <x-content.content-faq-component :content="$item" />


            </div>
        </section>

    </main>
@endsection

