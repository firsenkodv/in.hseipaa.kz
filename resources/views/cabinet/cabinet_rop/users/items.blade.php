@extends('layouts.layout')
<x-seo.meta
    title="Список пользователей"
    description="Список пользователей"
    keywords="Список пользователей"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('rop_users') }}
            </div>
            <x-cabinet.title
                :title="config('site.constants.head_sales_department')"
                :subtitle="$r->username "
            />

            <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                   <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>

                </div>

                <div class="block_content__right">
                  <x-cabinet-rop.user.user-list
                      :items="$users"
                      :managers="$managers"
                      :selected="(isset($manager_selected))?$manager_selected:''"
                      :value="(isset($manager_value))?$manager_value:''"
                      :markDelete="isset($markDelete) ? $markDelete : false"
                  />
                </div>

            </div>

        </div>
    </section>
@endsection
