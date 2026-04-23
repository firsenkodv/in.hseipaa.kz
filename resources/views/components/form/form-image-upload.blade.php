@props([
    'name'    => 'image',
    'label'   => 'Изображение',
    'rand'    => rand(100, 10000),
    'accept'  => 'image/*',
    'current' => null,
])

@php
    $hasCurrent = !empty($current);
    $currentUrl = $hasCurrent ? asset('storage/' . $current) : '';
@endphp

<div class="form-image-upload" id="upload_wrap_{{ $rand }}">
    <label for="upload_input_{{ $rand }}" class="form-image-upload__area {{ $hasCurrent ? 'has-file' : '' }}" id="upload_area_{{ $rand }}">
        <div class="form-image-upload__preview" id="upload_preview_{{ $rand }}" style="{{ $hasCurrent ? 'display:block' : 'display:none' }}">
            <img id="upload_img_{{ $rand }}" src="{{ $currentUrl }}" alt="{{ $label }}"/>
        </div>
        <div class="form-image-upload__placeholder" id="upload_placeholder_{{ $rand }}" style="{{ $hasCurrent ? 'display:none' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            <span class="form-image-upload__label">{{ $label }}</span>
            <span class="form-image-upload__hint">Нажмите для выбора файла</span>
        </div>
        <div class="form-image-upload__filename" id="upload_name_{{ $rand }}"></div>
    </label>

    <button
        type="button"
        class="form-image-upload__remove"
        id="upload_remove_{{ $rand }}"
        style="{{ $hasCurrent ? 'display:flex' : 'display:none' }}"
        title="Удалить файл"
    >&times;</button>

    <input
        type="file"
        id="upload_input_{{ $rand }}"
        name="{{ $name }}"
        accept="{{ $accept }}"
        class="form-image-upload__input"
    >
    <input
        type="hidden"
        id="upload_remove_flag_{{ $rand }}"
        name="remove_{{ $name }}"
        value="0"
    >
</div>

<script>
    (function () {
        var input       = document.getElementById('upload_input_{{ $rand }}');
        var area        = document.getElementById('upload_area_{{ $rand }}');
        var preview     = document.getElementById('upload_preview_{{ $rand }}');
        var img         = document.getElementById('upload_img_{{ $rand }}');
        var placeholder = document.getElementById('upload_placeholder_{{ $rand }}');
        var filename    = document.getElementById('upload_name_{{ $rand }}');
        var removeBtn   = document.getElementById('upload_remove_{{ $rand }}');
        var removeFlag  = document.getElementById('upload_remove_flag_{{ $rand }}');

        input.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;

            filename.textContent = file.name;

            if (file.type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }

            area.classList.add('has-file');
            removeBtn.style.display = 'flex';
        });

        removeBtn.addEventListener('click', function () {
            input.value = '';
            img.src = '';
            filename.textContent = '';
            preview.style.display = 'none';
            placeholder.style.display = 'flex';
            area.classList.remove('has-file');
            removeBtn.style.display = 'none';
            removeFlag.value = '1';
        });

        input.addEventListener('change', function () {
            if (this.files[0]) {
                removeFlag.value = '0';
            }
        });
    })();
</script>
