<div class="modal-form-container mini  app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response />
    <div class="modal_padding relative app_modal ">
        <div class="form_title pad_b18_important">
            <div class="form_title__h1">{{ $tarif->title }}</div>
            <div class="form_title__h2">{{ $tarif->subtitle }}, {{ $tarif->mpr }}, {{ price($tarif->price) }} {{ config('currency.currency.KZT') }}</div>
        </div>
        <div class="form_data app_form_data pad_b18_important">
            Отправьте нам заявку. И наш менеджер свяжется с вами и поможет вам подключить тариф.

            <x-form.form-input
                name="tarif"
                type="text"
                label="{{ $tarif->id }}"
                value="{{ $tarif->id }}"
                disabled="{{ true }}"
            />


        </div>
        <div class="input-button ">
            <x-form.form-button class="w_265_px_important"  url="select_tarif" >Отправить заявку</x-form.form-button>
        </div>
    </div>
</div>


