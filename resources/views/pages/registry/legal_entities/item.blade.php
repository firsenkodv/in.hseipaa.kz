@extends('layouts.layout')
<x-seo.meta
    title=""
    description=""
    keywords=""
/>
@section('content')
    <main>

        <section>
            <div class="block block_content">

                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('registry_legal_entity', $item) }}</div>
                <div class="block_content__title">
                    <h1 class="h1">{{ \App\Enums\User\RegistryStatus::LEGALENTITY->text() }}</h1>
                        <p class="_subtitle">{{ config2('moonshine.setting.sub_title_legal_entities')}}</p>
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                       <x-menu.left-menu-component menu="registry" route=""/>
                    </div>
                    <div class="block_content__right">
                        <x-content.registry.teaser :item="$item" :user="$user" />
                        <x-content.registry.content-registry-user-component :item="$item" :user="$user"  />
                    </div>
                </div>


            </div>
        </section>

    </main>
@endsection


