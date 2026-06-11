<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Дисциплина успешно обновлена."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b18_important">
            <div class="form_title__h1">Редактировать дисциплину</div>
        </div>

        <div class="form_data app_form_data pad_b18_important">

            <input type="hidden" name="training_id" class="app_input_name" value="{{ $training->id }}">

            <x-form.form-input
                name="title"
                type="text"
                label="Название"
                value="{{ $training->title }}"
                :required="true"
                :autofocus="true"
            />

        </div>

        <div class="input-button">
            <x-form.form-button url="admin_training_update">
                Сохранить
            </x-form.form-button>
        </div>

    </div>
</div>
