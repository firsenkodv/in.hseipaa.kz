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
                {{ Breadcrumbs::render('cabinet_update_personal_data_rop') }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.edit_personal_data')"
                :subtitle="$r->username"
            />

          <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>
                </div>

                <div class="block_content__right">
                    <x-cabinet-rop.update.cabinet-rop-update :user="$r" />
                </div>

            </div>

        </div>
    </section>
@endsection

