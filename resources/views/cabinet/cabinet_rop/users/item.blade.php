@extends('layouts.layout')
<x-seo.meta
    title="Пользователь {{ $user->username }} | {{ $user->email }}"
    description="Пользователь {{ $user->username }} | {{ $user->email }}"
    keywords="Пользователь {{ $user->username }} | {{ $user->email }}"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('rop_update_user', $user) }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.head_sales_department')"
                :subtitle="$r->username"
                :mini="\App\Enums\Moonshine\SuperEditorEnum::fromValue($r->super)->toString(true)"
            />
            <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">
                <div class="block_content__left">
                    <x-cabinet.main-manager :item="$user->Manager"/>
                    <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>
                </div>

                <div class="block_content__right">


                    @if($r->super == \App\Enums\Moonshine\SuperEditorEnum::SUPEREDITOR->value)
                        <div class="well_green">
                            <h3 class="h2">{{\App\Enums\Moonshine\SuperEditorEnum::fromValue($r->super)->toString(true)}}</h3>
                        </div>
                        <x-cabinet-rop.user.update.cabinet-rop-update-user :item="$user"/>
                    @else
                        <div class="well_yellow">
                            <h3 class="h2">{{\App\Enums\Moonshine\SuperEditorEnum::fromValue($r->super)->toString(true)}}</h3>
                        </div>
                        <x-cabinet.user-no-edit :user="$user"/>
                    @endif
                </div>

            </div>

        </div>
    </section>
@endsection

