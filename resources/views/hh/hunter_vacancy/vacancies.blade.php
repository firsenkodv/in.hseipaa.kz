@extends('layouts.layout')
<x-seo.meta
    title="Вакансии"
    description="Вакансии"
    keywords="Вакансии"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('vacancies') }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex">

                <div class="block_content__left">
                    <x-menu.hh-menu-component/>
                    <x-h-h.vacancy.user-vacancy-selection-component :user="$user"  />

                </div>

                <div class="block_content__right">
                    <x-form.form
                        action="{{ route('vacancy_search') }}"
                        method="get"
                    >

                        <div class="cu_row_50">
                            <div class="cu__col">
                                <x-form.form-select-cabinet
                                    name="Выберите город"
                                    :selected="(isset($fields['city']))?$fields['city']['title'] :''"
                                    :value="(isset($fields['city']))?$fields['city']['id']:''"
                                    :options="$cities"
                                    field_name="city"
                                />
                            </div>

                            <div class="cu__col">
                                <x-form.form-select-cabinet
                                    name="Выберите вакансию"
                                    :selected="(isset($fields['vacancy']))?$fields['vacancy']['title'] :''"
                                    :value="(isset($fields['vacancy']))?$fields['vacancy']['id']:''"
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
                                        :url="$route"
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

                    <div class="block_content__items">
                        @forelse($items as $item)
                            <div class="teaser">
                                <div class="teaser__flex">
                                    <div class="left">
                                        <h2><a href="{{ route('vacancy', $item->id) }}">{{ $item->title }}</a></h2>
                                        @if($item->subtitle)
                                            <div class="subtitle">{{ $item->subtitle }}</div>
                                        @endif                                        <div
                                            class="price">{{ price($item->price) }} {{ config('currency.currency.KZT') }}</div>
                                        @if($item->company)
                                            <div class="company">{{ $item->company }}</div>
                                        @endif
                                    </div>
                                    <div class="right">
                                        @php
                                            $img = ($item->logo)?:($item->img??'');
                                        @endphp
                                        @if($img)
                                            <a href="{{ route('vacancy', $item->id) }}"><img
                                                    src="{{ asset(intervention('80x80', $img, 'hh/intervention')) }}"
                                                    alt="{{ $item->title }}"/></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="teaser__short_desc">

                                    <a href="{{ route('vacancy', $item->id) }}" class="btn btn-middle">Посмотреть</a>
                                </div>
                            </div>
                        @empty
                            <div class="Not_yet">Вакансии не найдены</div>
                        @endforelse
                    </div>

                    {{ $items->withQueryString()->links('pagination::default') }}

                </div>

            </div>


        </div>
    </section>
@endsection


