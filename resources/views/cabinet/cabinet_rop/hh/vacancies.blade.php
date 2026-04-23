@extends('layouts.layout')
@php
    $isModer = request()->routeIs('rop_hh_vacancies_moder', 'rop_hh_vacancy_moder');
    $pageTitle = $isModer ? 'Вакансии на модерации' : 'Вакансии';
    $breadcrumb = $isModer ? 'rop_hh_vacancies_moder' : 'rop_hh_vacancies';
@endphp
<x-seo.meta
    :title="$pageTitle"
    :description="$pageTitle"
    :keywords="$pageTitle"
/>

@section('content')
    <section>
        <div class="block block_content cabinet_user">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render($breadcrumb) }}
            </div>
            <x-cabinet.title
                :title="config('site.constants.head_sales_department')"
                :subtitle="$r->username"
                :mini="$pageTitle"
            />

            <x-cabinet-rop.menu.cabinet-rop-top-menu :user="$r"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-cabinet-rop.cabinet-rop-personal-data-relation :user="$r"/>
                </div>

                <div class="block_content__right">

                    <x-form.form
                        :action="route($breadcrumb)"
                        method="get"
                    >
                        <div class="cu_row_50">
                            <div class="cu__col">
                                <x-form.form-select-cabinet
                                    name="Выберите город"
                                    :selected="$fields['city']['title'] ?? ''"
                                    :value="$fields['city']['id'] ?? ''"
                                    :options="$cities"
                                    field_name="city"
                                />
                            </div>
                            <div class="cu__col">
                                <x-form.form-select-cabinet
                                    name="Выберите категорию"
                                    :selected="$fields['category']['title'] ?? ''"
                                    :value="$fields['category']['id'] ?? ''"
                                    :options="$categories"
                                    field_name="category"
                                />
                            </div>
                        </div>
                        <div class="cu_row_50">
                            <div class="cu__col"></div>
                            <div class="cu__col">
                                <div class="r__flex">
                                    <x-form.form-submit
                                        :url="route($breadcrumb)"
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

                    <div class="cabinet__users_scroll">
                        <div class="cabinet__users">

                            @if(count($items))

                                <div class="dashboardBox__title">
                                    <div class="u_teaser u_teaser_label">
                                        <div class="username">Название</div>
                                        <div class="email">Пользователь</div>
                                        <div class="options">Категория / Город</div>
                                    </div>
                                </div>

                                @foreach($items as $item)
                                    <a href="{{ route($isModer ? 'rop_hh_vacancy_moder' : 'rop_hh_vacancy', $item->id) }}" class="user_user-list-item u_teaser">
                                        <div class="username">
                                            @if($item->published)
                                                <span class="blue">{{ $item->title }}</span>
                                            @else
                                                <span class="red">{{ $item->title }}</span>
                                            @endif
                                        </div>
                                        <div class="email">
                                            {{ $item->user?->username ?? '—' }}
                                        </div>
                                        <div class="options">
                                            {{ $item->category?->title ?? '—' }}
                                            @if($item->city) · {{ $item->city->title }} @endif
                                        </div>
                                    </a>
                                @endforeach

                                <div class="pad_t20">
                                    {{ $items->links('pagination::default') }}
                                </div>

                            @else
                                <p>Вакансий нет.</p>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
