@extends('layouts.layout')
<x-seo.meta
    title="Редактировать резюме"
    description="Редактировать резюме"
    keywords="Редактировать резюме"
/>
@section('content')
    <section>
        <div class="block block_content cabinet_user hh">
            <div class="block_content__breadcrumbs">
                {{ Breadcrumbs::render('my_resume_edit', $item) }}
            </div>

            <x-cabinet.title
                title="Мой профиль"
                :subtitle="(isset($user->UserHuman->title))?$user->UserHuman->title:'' "
                mini="Редактировать резюме"
            />
            <x-cabinet-user.menu.cabinet-user-top-menu :user="$user"/>

            <div class="block_content__flex reverse">

                <div class="block_content__left">
                    <x-menu.hh-menu-component :my="true"/>
                    <x-h-h.resume.user-resume-selection-component :user="$user"/>
                </div>

                <div class="block_content__right">
                    <x-form.form action="{{ route('my_resume_update', $item->id) }}" enctype="multipart/form-data" :put="true">

                        @php
                            $oldCategoryId   = old('hunter_category_id', $item->hunter_category_id);
                            $oldCityId       = old('user_city_id', $item->user_city_id ?? '');
                            $oldExperienceId = old('hunter_experience_id', $item->hunter_experience_id);

                            $oldCategoryTitle   = $oldCategoryId
                                ? (collect($categories)->firstWhere('id', $oldCategoryId)['title'] ?? '')
                                : '';
                            $oldCityTitle       = $oldCityId
                                ? (collect($cities)->firstWhere('id', $oldCityId)['title'] ?? '')
                                : '';
                            $oldExperienceTitle = $oldExperienceId
                                ? (collect($experiences)->firstWhere('id', $oldExperienceId)['title'] ?? '')
                                : '';
                        @endphp

                        <x-form.form-input
                            name="title"
                            label="Название резюме"
                            :required="true"
                            :value="old('title', $item->title)"
                        />

                        <x-form.form-input
                            name="subtitle"
                            label="Подзаголовок"
                            :value="old('subtitle', $item->subtitle ?? '')"
                        />

                        <x-form.form-input
                            name="post"
                            label="Должность"
                            :value="old('post', $item->post ?? '')"
                        />

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
                                label="Желаемая зарплата"
                                class="js-price-mask"
                                :value="old('price', $item->price ?? '')"
                            />
                            <span class="input-group-currency__symbol">{{ config('currency.currency.KZT') }}</span>
                        </div>

                        <x-form.form-textarea
                            name="desc"
                            label="О себе"
                            :editor="true"
                            :value="old('desc', $item->desc ?? '')"
                        />

                        <x-form.form-textarea
                            name="must"
                            label="Навыки"
                            :editor="true"
                            :value="old('must', $item->must ?? '')"
                        />

                        <x-form.form-textarea
                            name="conditions"
                            label="Пожелания"
                            :editor="true"
                            :value="old('conditions', $item->conditions ?? '')"
                        />

                        <x-form.form-input
                            name="address"
                            label="Адрес"
                            :value="old('address', $item->address ?? '')"
                        />

                        <x-form.form-input
                            name="email"
                            label="Email"
                            type="email"
                            :value="old('email', $item->email ?? '')"
                        />

                        <x-form.form-input
                            name="phone"
                            label="Телефон"
                            class="imask"
                            :value="old('phone', $item->phone ? phone($item->phone) : '')"
                        />

                        <x-form.form-input
                            name="telegram"
                            label="Telegram"
                            :value="old('telegram', $item->telegram ?? '')"
                            description="Заполняйте правильно - <span>@hseipaa</span> или <span>t.me/hseipaa</span>"
                        />

                        <x-form.form-input
                            name="whatsapp"
                            label="WhatsApp"
                            :value="old('whatsapp', $item->whatsapp ?? '')"
                            description="Указывайте только номер, без + и пробелов - <span>77075594060</span>"
                        />

                        <br>
                        <x-form.form-submit
                            class="btn btn-big"
                            type="submit"
                        >Сохранить изменения
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
        var form = document.querySelector('.row_form_800');
        if (form) {
            form.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'TRIX-EDITOR') {
                    e.preventDefault();
                    form.requestSubmit();
                }
            });
        }

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
