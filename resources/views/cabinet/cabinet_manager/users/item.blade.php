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
                {{ Breadcrumbs::render('manager_update_user', $user) }}
            </div>

            <x-cabinet.title
                :title="config('site.constants.manager')"
                :subtitle="$m->username"
            />

            <x-cabinet-manager.menu.cabinet-manager-top-menu :user="$m"/>

            <div class="block_content__flex reverse">
                <div class="block_content__left">
                    <x-cabinet.main-manager :item="$user->Manager"/>
                    <x-cabinet-manager.cabinet-manager-personal-data-relation :user="$m"/>
                </div>

                <div class="block_content__right">


                    @if($m->super == \App\Enums\Moonshine\SuperEditorEnum::SUPEREDITOR->value)
                        <div class="well green right">
                            <div class="well__text">{{\App\Enums\Moonshine\SuperEditorEnum::fromValue($m->super)->toString(true)}}</div>
                        </div>
                        <br>
                        <x-cabinet-manager.user.update.cabinet-manager-update-user :item="$user"/>
                    @else
                        <div class="well red right"><div class="well__text">{{\App\Enums\Moonshine\SuperEditorEnum::fromValue($m->super)->toString(true)}}</div>
                        </div>
                        <br>
                        <x-cabinet.user-no-edit :user="$user" role="manager"/>
                    @endif
                </div>

            </div>

        </div>
    </section>
@endsection

