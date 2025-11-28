@extends('layouts.layout')
<x-seo.meta
    title="{{ config2('moonshine.new.metatitle') }}"
    description="{{ config2('moonshine.new.description') }}"
    keywords="{{ config2('moonshine.new.keywords') }}"
/>

@section('content')
    <main>

        <section>
            <div class="block block_content">
                <div class="block_content__breadcrumbs">  {{ Breadcrumbs::render('site_new_categories') }}</div>
                <div class="block_content__title"><h1 class="h1">{{ config2('moonshine.new.title') }}</h1>
                    @if(config2('moonshine.new.subtitle'))
                        <p class="_subtitle">{{ config2('moonshine.new.subtitle')}}</p>
                    @endif
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                     <x-menu.left-menu-component menu="news" />
                    </div>
                    <div class="block_content__right">
                        @if(config2('moonshine.company.desc'))
                            <div class="desc pad_b30">
                            <div class="_desc bl_desc">{!! config2('moonshine.new.desc') !!}</div>
                            </div>
                        @endif


                            @if($categories->isNotEmpty())
                                <div class="teaser">
                                    @foreach($categories as $category)

                                        <x-content.teaser-component :content="$category" :url="route('site_new_categories')" />

                                    @endforeach
                                    {{ $categories->withQueryString()->links('pagination::default') }}
                                </div>
                            @endif


                    </div>
                </div>

                <x-content.content-faq-component :content="$faq" />


            </div>
        </section>

    </main>
@endsection



