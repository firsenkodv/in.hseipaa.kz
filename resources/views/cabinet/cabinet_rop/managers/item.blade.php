@extends('layouts.layout')
<x-seo.meta
    title="Менеджер {{ $item->username }} | {{ $item->email }}"
    description="Менеджер {{ $item->username }} | {{ $item->email }}"
    keywords="Менеджер {{ $item->username }} | {{ $item->email }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('rop_update_manager', $item) }}
            </div>
            <div class="block_content__title"><h1 class="h1">{{ config('site.constants.head_sales_department') }}</h1>
                <p class="_subtitle">{{ $r->username }}</p>
            </div>

            <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">


                    <x-cabinet.main-manager :item="$item"/>
                    <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>
                </div>

                <div class="block_content__right">

                    <x-cabinet-rop.manager.update.cabinet-rop-update-manager :item="$item"/>

                </div>

            </div>

        </div>
    </section>
@endsection

