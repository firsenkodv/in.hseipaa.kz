@extends('layouts.layout')
<x-seo.meta
    title="{{ config('site.constants.admin') }}"
    description="{{ config('site.constants.admin') }}"
    keywords="{{ config('site.constants.admin') }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_admin') }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.admin')"
                :subtitle="$a->username"
            />

            <x-cabinet-admin.menu.cabinet-admin-top-menu :user="$a"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-admin.cabinet-admin-personal-data-relation :user="$a"/>
                </div>

                <div class="block_content__right">
                    <x-cabinet-admin.cabinet-admin-personal-data :user="$a"/>
                </div>

            </div>

        </div>
    </section>
@endsection
