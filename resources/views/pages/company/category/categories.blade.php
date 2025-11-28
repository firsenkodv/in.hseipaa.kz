@extends('layouts.layout')
<x-seo.meta
    title="{{ config2('moonshine.company.metatitle') }}"
    description="{{ config2('moonshine.company.description') }}"
    keywords="{{ config2('moonshine.company.keywords') }}"
/>

@section('content')
    <main>

        <section>
            <div class="block block_content">
                <div class="block_content__breadcrumbs">{{ Breadcrumbs::render('company_categories') }}</div>
                <div class="block_content__title"><h1 class="h1">{{ config2('moonshine.company.title') }}</h1>
                    @if(config2('moonshine.company.subtitle'))
                        <p class="_subtitle">{{ config2('moonshine.company.subtitle')}}</p>
                    @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                    <x-menu.left-menu-component menu="companies" />
                    </div>
                    <div class="block_content__right">
                        <div class="desc">
                            @if(config2('moonshine.company.desc'))
                                <div class="_desc bl_desc">{!! config2('moonshine.company.desc') !!}</div>
                            @endif
                        </div>

                    </div>
                </div>
                <x-content.content-faq-component :content="$faq" />


            </div>
        </section>

    </main>
@endsection



