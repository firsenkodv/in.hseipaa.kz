@extends('layouts.layout')
<x-seo.meta
    title="{{ config('site.constants.manager') }}"
    description="{{ config('site.constants.manager') }}"
    keywords="{{ config('site.constants.manager') }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('cabinet_manager') }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.manager')"
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


