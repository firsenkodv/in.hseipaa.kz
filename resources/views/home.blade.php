@extends('layouts.layout')
<x-seo.meta
    title="{!!  (config2('moonshine.home.metatitle')) !!}"
    description="{!!  (config2('moonshine.home.description')) !!}"
    keywords="{!!  (config2('moonshine.home.keywords'))  !!}"
/>
@section('content')

    <section>
        <div class="block relative">
            <div class="exchange">
                <div class="mod_search_blue">

                    <div class="m_sb_top">
                        <h2>{{ config2('moonshine.setting.mzp_title') }}</h2>
                    </div>
                    <div class="m_sb_middle">

                        <x-form.form
                            method="POST"
                            :action="route('search')"
                        >
                            <div class="row_form_800__left">
                                <input id="input_text" placeholder="Поиск..." name="search"  type="text"  maxlength="50">
                            </div>

                            <div class="row_form_800__right">
                                <button type="submit" class="btn btn-big"><span>Найти</span></button>
                            </div>

                        </x-form.form>

                    </div>
                    <div class="m_sb_bottom">
                        <div class="sub_m_sb_flex ">
                            <x-api.nationalbank-component />
                            <x-api.mzp-component />
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="block relative">
            <x-home.output-category-component />
        </div>
    </section>

    <section>
        <div class="block relative">
            <x-home.output-news-component />
        </div>
    </section>

    <section>
        <div class="block relative">
            <x-home.output-service-category-component />
        </div>
    </section>
    <section>
        <div class="block relative">
            <x-home.consultation-component />
        </div>
    </section>

    <section>
        <div class="block relative">
            <x-home.useful-info-component />
        </div>
    </section>

    <section>
        <div class="block relative">
            <x-home.everything-personal-account-component />
        </div>
    </section>

    <section class="">
        <div class="block relative pad_t18">
            <x-content.content-faq-component :content="$faq" />
        </div>
    </section>

@endsection
