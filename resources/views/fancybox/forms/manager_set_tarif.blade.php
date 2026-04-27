<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response/>
    <div class="modal_padding relative app_modal">
        <div class="form_title pad_b18_important">
            <div class="form_title__h1">Изменить <span class="red">тариф</span></div>
            <div class="form_title__h2">Пользователь: <span class="black"><strong>{{ $user->username }}</strong></span> / <span class="black">{{ $user->email }}</span>
            </div>
        </div>
        <div class="form_data app_form_data">

            <input type="hidden" class="app_input_name" name="user_id" value="{{ $user->id }}">
            <input type="hidden" class="app_input_name" name="tarif_id" id="js_tarif_selected" value="{{ $user->tarif_id ?? 0 }}">

            <div class="ms_tarif_list">
                @foreach($tarifs as $tarif)
                    <div class="ms_tarif_card {{ ($user->tarif_id == $tarif->id) ? 'is-selected' : '' }}"
                         data-id="{{ $tarif->id }}">
                        <div class="ms_tarif_card__radio"></div>
                        <div class="ms_tarif_card__body">
                            <div class="ms_tarif_card__title">{{ $tarif->title }}</div>
                            <div class="ms_tarif_card__sub">{{ $tarif->subtitle }}</div>
                        </div>
                        <div class="ms_tarif_card__price">{{ price($tarif->price) }} {{ config('currency.currency.KZT') }}</div>
                    </div>
                @endforeach

                <div class="ms_tarif_card ms_tarif_card--none {{ (!$user->tarif_id) ? 'is-selected' : '' }}"
                     data-id="0">
                    <div class="ms_tarif_card__radio"></div>
                    <div class="ms_tarif_card__body">
                        <div class="ms_tarif_card__title">Без тарифа</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="input-button">
            <x-form.form-button url="cabinet-manager/set-tarif">Сохранить</x-form.form-button>
        </div>
    </div>
</div>
