@extends('layouts.layout')
<x-seo.meta
    title="{{ config2('moonshine.setting.mzp_page_title') }} | {{ config2('moonshine.setting.mzp_page_subtitle') }}"
    description="{{ config2('moonshine.setting.mzp_page_subtitle') }}"
    keywords=""
/>

@section('content')
    <main>

        <section>
            <div class="block block_content">

                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('mzp_items') }}</div>

                <x-cabinet.title
                    :title="config2('moonshine.setting.mzp_page_title')"
                    :subtitle="config2('moonshine.setting.mzp_page_subtitle')"
                />

                <div class="block_content__block">
                    <x-mzp.mzp-content-component :items="$items" />
                </div>


            </div>
        </section>

    </main>
@endsection


