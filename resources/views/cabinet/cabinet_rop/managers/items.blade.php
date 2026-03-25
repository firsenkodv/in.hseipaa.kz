@extends('layouts.layout')
<x-seo.meta
    title="Список менеджеров"
    description="Список менеджеров"
    keywords="Список менеджеров"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('rop_managers') }}
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
                    <x-cabinet-rop.manager.manager-list :items="$items"/>
                        <div class="pad_t30">
                            <x-buttons.button-component
                                :href="route('rop_add_manager')"
                                class="btn btn-middle"
                            >Создать менеджера</x-buttons.button-component>
                    </div>

                </div>

            </div>

        </div>
    </section>
@endsection
