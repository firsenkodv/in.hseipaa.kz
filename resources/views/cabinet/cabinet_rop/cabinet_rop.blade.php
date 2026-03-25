@extends('layouts.layout')
<x-seo.meta
    title="{{ config('site.constants.head_sales_department') }}"
    description="{{ config('site.constants.head_sales_department') }}"
    keywords="{{ config('site.constants.head_sales_department') }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_rop') }}
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
                    <x-cabinet-rop.cabinet-rop-personal-data :user="$r"/>

                </div>

            </div>

        </div>
    </section>
@endsection

