@extends('layouts.layout')
<x-seo.meta
    title="Создать вакансию"
    description="Создать вакансию"
    keywords="Создать вакансию"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('my_vacancy_create') }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Создать вакансию"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-menu.hh-menu-component :my="true"/>
                    <x-h-h.vacancy.user-vacancy-selection-component :user="$user"/>
                </div>

                <div class="block_content__right">
                    <x-form.form action="{{ route('my_vacancy_store') }}" enctype="multipart/form-data">

                        @php
                            $oldCategoryId   = old('hunter_category_id');
                            $oldCityId       = old('user_city_id', $user->user_city_id ?? '');
                            $oldExperienceId = old('hunter_experience_id');

                            $oldCategoryTitle   = $oldCategoryId
                                ? (collect($categories)->firstWhere('id', $oldCategoryId)['title'] ?? '')
                                : '';
                            $oldCityTitle       = $oldCityId
                                ? (collect($cities)->firstWhere('id', $oldCityId)['title'] ?? ($user->UserCity?->title ?? ''))
                                : ($user->UserCity?->title ?? '');
                            $oldExperienceTitle = $oldExperienceId
                                ? (collect($experiences)->firstWhere('id', $oldExperienceId)['title'] ?? '')
                                : '';

                            $userAddress = implode(', ', array_filter([
                                $user->address['json_address_area']       ?? '',
                                $user->address['json_address_street']     ?? '',
                                $user->address['json_address_house']      ?? '',
                                $user->address['json_address_office']     ?? '',
                                $user->address['json_address_post_index'] ?? '',
                            ]));
                        @endphp

                        @if($user->legalEntity)
                            <x-form.form-image-upload
                                name="logo"
                                label="Логотип"
                            />

                            <x-form.form-input
                                name="company"
                                label="Компания"
                                :value="old('company', '')"
                            />

                            <x-form.form-input
                                name="post"
                                label="Должность"
                                :value="old('post', '')"
                            />
                        @endif

                        <x-form.form-input
                            name="title"
                            label="Название вакансии"
                            :required="true"
                            :value="old('title', '')"
                        />

                        <x-form.form-input
                            name="subtitle"
                            label="Подзаголовок"
                            :value="old('subtitle', '')"
                        />

                        @if(!$user->legalEntity)
                            <x-form.form-input
                                name="post"
                                label="Должность"
                                :value="old('post', '')"
                            />
                        @endif

                        <x-form.form-select-cabinet
                            name="Выберите категорию"
                            :options="$categories"
                            field_name="hunter_category_id"
                            :required="true"
                            :value="$oldCategoryId ?? ''"
                            :selected="$oldCategoryTitle"
                        />

                        <x-form.form-select-cabinet
                            name="Выберите город"
                            :options="$cities"
                            field_name="user_city_id"
                            :value="$oldCityId"
                            :selected="$oldCityTitle"
                        />

                        <x-form.form-select-cabinet
                            name="Опыт работы"
                            :options="$experiences"
                            field_name="hunter_experience_id"
                            :value="$oldExperienceId ?? ''"
                            :selected="$oldExperienceTitle"
                        />

                        <div class="input-group-currency">
                            <x-form.form-input
                                name="price"
                                label="Зарплата"
                                class="js-price-mask"
                                :value="old('price', '')"
                            />
                            <span class="input-group-currency__symbol">{{ config('currency.currency.KZT') }}</span>
                        </div>

                        <x-form.form-textarea
                            name="desc"
                            label="Описание"
                            :editor="true"
                            :value="old('desc', '')"
                        />

                        <x-form.form-textarea
                            name="must"
                            label="Требования"
                            :editor="true"
                            :value="old('must', '')"
                        />

                        <x-form.form-textarea
                            name="conditions"
                            label="Условия работы"
                            :editor="true"
                            :value="old('conditions', '')"
                        />

                        <x-form.form-input
                            name="address"
                            label="Адрес"
                            :value="old('address', $userAddress)"
                        />

                        <x-form.form-input
                            name="email"
                            label="Email"
                            type="email"
                            :value="old('email', $user->email ?? '')"
                        />

                        <x-form.form-input
                            name="phone"
                            label="Телефон"
                            class="imask"
                            :value="old('phone', $user->phone ?? '')"
                        />

                        <x-form.form-input
                            name="telegram"
                            label="Telegram"
                            :value="old('telegram', $user->telegram ?? '')"
                            description="Заполняйте правильно - <span>@hseipaa</span> или <span>t.me/hseipaa</span>"
                        />

                        <x-form.form-input
                            name="whatsapp"
                            label="WhatsApp"
                            :value="old('whatsapp', $user->whatsapp ?? '')"
                            description="Указывайте только номер, без + и пробелов - <span>77075594060</span>"
                        />

                        <br>
                        <x-form.form-submit
                            class="btn btn-big"
                            type="submit"
                        >Создать вакансию
                        </x-form.form-submit>

                    </x-form.form>
                </div>

            </div>

        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var priceInput = document.querySelector('.js-price-mask');
        if (!priceInput) return;

        var mask = IMask(priceInput, {
            mask: Number,
            thousandsSeparator: ' ',
            scale: 0,
            signed: false,
            normalizeZeros: false,
            min: 0,
        });

        priceInput.closest('form').addEventListener('submit', function () {
            priceInput.value = mask.unmaskedValue;
        });
    });
</script>
@endpush
