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

                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('mzp_item', $item) }}</div>
                <x-cabinet.title
                    :title="$item->title"
                    :subtitle="$item->subtitle"
                />
                <div class="block_content__flex">
                    <div class="block_content__left">
                        <x-mzp.mzp-menu-component />
                    </div>
                    <div class="block_content__right">
                        <x-mzp.mzp-content-component :item="$item" />
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection


