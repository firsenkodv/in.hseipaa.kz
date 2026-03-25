@extends('layouts.layout')
<x-seo.meta
    title="Создание менеджера"
    description="Создание менеджера"
    keywords="Создание менеджера"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('rop_add_manager') }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.head_sales_department')"
                :subtitle="$r->username"
            />

            <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>
                </div>

                <div class="block_content__right">

                    <div class="well_yellow">
                        <h3 class="h2">Создание менеджера</h3>
                    </div>
                    <x-cabinet-rop.manager.add.cabinet-rop-add-manager />

                </div>

            </div>

        </div>
    </section>
@endsection


