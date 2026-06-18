@props([
    'name'      => 'certificates',
    'title'     => 'Сертификаты (PDF)',
    'reportId'  => '',
    'value'     => [],
    'rand'      => rand(100, 10000),
])

<div class="input-file app_input-file app_input-file-report"
     data-initialfiles='{{ json_encode($value) }}'
     data-reportid="{{ $reportId }}">
    <div class="input-file__flex">
        <div class="input-file__left">
            <div class="input-file__title">{{ $title }}</div>
        </div>
        <div class="input-file__right">
            <div class="input_cover"></div>
            <div class="load_spinner">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <div class="uploadedFiles">
                @if($value && count($value))
                    @foreach($value as $file)
                        <p data-strfile="{{ $file['json_file'] }}">
                            <a href="{{ $file['url'] }}" download="" target="_blank">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                            <i class="delete_cross app_delete_cross_report"></i>
                        </p>
                    @endforeach
                @endif
            </div>
            <label for="reportFileInput_{{ $rand }}">+</label>
        </div>
    </div>

    <input type="file"
           id="reportFileInput_{{ $rand }}"
           class="take__save app_report_file_input"
           multiple
           accept=".pdf" />

    <input type="hidden"
           name="{{ $name }}"
           class="app_input_name app_report_certificates_json"
           value="{{ json_encode($value) }}" />
</div>
