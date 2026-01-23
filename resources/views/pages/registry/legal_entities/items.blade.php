@extends('layouts.layout')
<x-seo.meta
    title=""
    description=""
    keywords=""
/>
@section('content')
    <main>

        <section>
            <div class="block block_content">

                <div class="block_content__breadcrumbs"> {{ Breadcrumbs::render('registry_legal_entities') }}</div>
                <div class="block_content__title"><h1 class="h1">{{ \App\Enums\User\RegistryStatus::LEGALENTITY->text() }}</h1>
                    <p class="_subtitle">{{ config2('moonshine.setting.sub_title_legal_entities')}}</p>
                </div>
                <div class="block_content__flex">
                    <div class="block_content__left">
                        <x-menu.left-menu-component menu="registry" route=""/>
                    </div>
                    <div class="block_content__right">

                        <div class="content_content-registry-search-component">
                            <x-form.form
                                action="{{ route('registry_legal_entities_search') }}"
                                method="get"
                            >

                                        <x-form.form-select-cabinet
                                            name="Выберите город"
                                            :selected="(isset($fields['city']))?$fields['city']['title'] :''"
                                            :value="(isset($fields['city']))?$fields['city']['id']:''"
                                            :options="$cities"
                                            field_name="city"
                                        />

                                <x-form.form-input
                                    name="search"
                                    type="text"
                                    label="Поиск компании"
                                    error=""
                                    value="{{  (old('search')) ?: ($fields['search'])??'' }}"

                                />
                                <x-form.form-input
                                    name="route"
                                    type="text"
                                    label=""
                                    error=""
                                    value="{{ $route }}"
                                    class="display_none"

                                />

                                <div class="cu_row_50">
                                    <div class="cu__col"></div>
                                    <div class="cu__col">
                                        <div class="r__flex">
                                            <x-form.form-submit
                                                url="{{ route($route) }}"
                                                class="btn btn-big r_pad_r_ app_r_reset"
                                            >Сброс
                                            </x-form.form-submit>

                                            <x-form.form-submit
                                                class="btn btn-big"
                                                type="submit"
                                            >Найти
                                            </x-form.form-submit>
                                        </div>
                                    </div>
                                </div>

                            </x-form.form>
                        </div>

                        <x-content.registry.content-registry-users-component :items="$items" route="registry_legal_entity" :user="$user"/>

                    </div>
                </div>

                {{-- <x-content.content-faq-component :content="$item" />--}}

            </div>
        </section>

    </main>
@endsection


