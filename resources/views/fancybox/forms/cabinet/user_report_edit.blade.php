<div class="modal-form-container mini app_form_modal">
    <x-form.form-loader/>
    <x-form.form-response message="Отчёт успешно обновлён."/>
    <div class="modal_padding relative app_modal">

        <div class="form_title pad_b30_important">
            <div class="form_title__h1">Редактировать отчёт</div>
        </div>

        <div class="form_data app_form_data pad_b18_important">

            <input type="hidden" name="report_id" class="app_input_name" value="{{ $report->id }}">

            <div id="report-period" class="period-range-wrapper">
                <x-form.form-input-datepicker
                    name="report_period_from"
                    label="Начало периода"
                    value="{{ $report->period_from->format('d.m.Y') }}"
                    required="{{ true }}"
                />
                <x-form.form-input-datepicker
                    name="report_period_to"
                    label="Конец периода"
                    value="{{ $report->period_to->format('d.m.Y') }}"
                    required="{{ true }}"
                />
            </div>

            <x-form.form-input
                name="report_type"
                type="text"
                label="Вид отчёта (обязательные дисциплины)"
                value="{{ $report->report_type }}"
                required="{{ true }}"
            />

            <x-form.form-input
                name="discipline_name"
                type="text"
                label="Наименование дисциплины"
                value="{{ $report->discipline_name }}"
                required="{{ true }}"
            />

            <x-form.form-input
                name="school_name"
                type="text"
                label="Наименование учебного заведения"
                value="{{ $report->school_name }}"
                required="{{ true }}"
            />

            <x-form.form-upload-report-files
                name="certificates"
                title="Сертификат pdf"
                :reportId="$report->id"
                :value="$report->certificates ? $report->certificates->toArray() : []"
            />

        </div>

        <div class="input-button">
            <x-form.form-button url="user_report_update">
                Сохранить изменения
            </x-form.form-button>
        </div>

    </div>
</div>
