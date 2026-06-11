@extends('layouts.layout')
<x-seo.meta
    title="Договоры"
    description="Договоры"
    keywords="Договоры"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('manager_contracts') }}
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
                    <x-cabinet-admin.contract.admin-contracts-list :contracts="$contracts"/>
                </div>

            </div>

        </div>
    </section>
@endsection
