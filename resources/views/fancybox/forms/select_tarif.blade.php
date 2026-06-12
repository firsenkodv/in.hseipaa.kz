<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <div class="modal_padding relative app_modal">
        <div class="form_title pad_b18_important">
            <div class="form_title__h1">{{ $tarif->title }}</div>
            <div class="form_title__h2">{{ $tarif->subtitle }}</div>
        </div>
        <div class="form_data app_form_data pad_b18_important">
            <div class="tarif_modal_price">
                {{ price($tarif->price) }} {{ config('currency.currency.KZT') }}
            </div>
            <div class="tarif_modal_mpr">{{ $tarif->mpr }}</div>
        </div>
        <div class="input-button">
            <a href="{{ route('cabinet_payment_init', ['tarif_id' => $tarif->id]) }}"
               class="btn w_265_px_important">Оплатить</a>
        </div>
    </div>
</div>
