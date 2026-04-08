@extends('layouts.layout')
<x-seo.meta
    title="{{ config('site.constants.edit_personal_data') }}"
    description="{{ config('site.constants.edit_personal_data') }}"
    keywords="{{ config('site.constants.edit_personal_data') }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
              {{--  {{ Breadcrumbs::render('cabinet_update_personal_data_rop') }}--}}
            </div>

            <x-cabinet.title
                :title="config('site.constants.edit_personal_data')"
                :subtitle="$m->username"
            />

            <x-cabinet-manager.menu.cabinet-manager-top-menu :user="$m"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-manager.cabinet-manager-personal-data-relation :user="$m"/>
                </div>

                <div class="block_content__right">
                    <x-cabinet-manager.cabinet-manager-personal-data :user="$m"/>
                </div>

            </div>

        </div>
    </section>
@endsection

