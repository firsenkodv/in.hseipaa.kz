<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Отчёт успешно создан."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b30_important">
            <div class="form_title__h1">Создать отчёт</div>
            <div class="form_title__h2">Заполните данные об отчёте</div>
        </div>

        <div class="form_data app_form_data pad_b18_important">

            <div id="report-period" class="period-range-wrapper">
                <x-form.form-input-datepicker
                    name="report_period_from"
                    label="Начало периода"
                    required="{{ true }}"
                />
                <x-form.form-input-datepicker
                    name="report_period_to"
                    label="Конец периода"
                    required="{{ true }}"
                />
            </div>

            <x-form.form-input
                name="report_type"
                type="text"
                label="Вид отчёта (обязательные дисциплины)"
                required="{{ true }}"
            />

            <x-form.form-input
                name="discipline_name"
                type="text"
                label="Наименование дисциплины"
                required="{{ true }}"
            />

            <x-form.form-input
                name="school_name"
                type="text"
                label="Наименование учебного заведения"
                required="{{ true }}"
            />

            <x-form.form-upload-report-files
                name="certificates"
                title="Сертификат pdf"
            />

        </div>

        <div class="input-button">
            <x-form.form-button url="user_report_create">
                Создать отчёт
            </x-form.form-button>
        </div>

    </div>
</div>
