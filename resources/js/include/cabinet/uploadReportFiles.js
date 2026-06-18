import { axiosLaravel } from '../axios/axiosLaravel';

export function uploadReportFiles() {
    const fileInputs = Array.from(document.querySelectorAll('.app_report_file_input'));
    if (!fileInputs.length) return;

    for (const fileInput of fileInputs) {
        fileInput.onchange = async function (e) {
            const parentEl     = e.target.closest('.app_input-file-report');
            const reportId     = parentEl.dataset.reportid || '';
            const selectedFiles = e.target.files;

            const initialFilesRaw = parentEl.dataset.initialfiles;
            const existingFiles   = initialFilesRaw ? JSON.parse(initialFilesRaw) : [];

            for (const file of selectedFiles) {
                if (file.type !== 'application/pdf') {
                    alert(`Файл "${file.name}": разрешены только PDF.`);
                    return;
                }
                if (file.size > 15728640) {
                    alert(`Файл "${file.name}" превышает 15 MB.`);
                    return;
                }
            }

            if (existingFiles.length + selectedFiles.length > 4) {
                alert('Всего можно загрузить до 4 файлов.');
                return;
            }

            spinnerStart(parentEl);

            const formData = new FormData();
            Array.from(selectedFiles).forEach((file, i) => {
                formData.append(`files[${i}]`, file);
            });
            if (reportId) formData.append('report_id', reportId);

            try {
                const response = await axiosLaravel(formData, '/cabinet.upload.report.files');
                if (response.success) {
                    const combined = [...existingFiles, ...response.files].slice(0, 4);
                    updateFilesDisplay(parentEl, combined);
                }
            } catch (err) {
                console.error('Ошибка загрузки файла отчёта:', err);
            }

            spinnerFinish(parentEl);
        };
    }

    setupDeleteButtons();
}

function setupDeleteButtons() {
    const containers = document.querySelectorAll('.app_input-file-report .uploadedFiles');
    containers.forEach(container => {
        container.addEventListener('click', async (e) => {
            if (!e.target.matches('.app_delete_cross_report')) return;

            const p        = e.target.closest('p');
            const strFile  = p.dataset.strfile;
            const parentEl = e.target.closest('.app_input-file-report');
            const reportId = parentEl.dataset.reportid || '';

            spinnerStart(parentEl);

            const formData = new FormData();
            formData.append('json_file', strFile);
            if (reportId) formData.append('report_id', reportId);

            try {
                const response = await axiosLaravel(formData, '/cabinet.delete.report.files');
                if (response.success) {
                    const initialFilesRaw = parentEl.dataset.initialfiles;
                    const currentFiles    = initialFilesRaw ? JSON.parse(initialFilesRaw) : [];
                    const updatedFiles    = currentFiles.filter(f => f.json_file !== strFile);
                    updateFilesDisplay(parentEl, updatedFiles);
                }
            } catch (err) {
                console.error('Ошибка удаления файла отчёта:', err);
            }

            spinnerFinish(parentEl);
        });
    });
}

function updateFilesDisplay(parentEl, files) {
    const container = parentEl.querySelector('.uploadedFiles');
    container.innerHTML = '';
    files.forEach(file => {
        container.insertAdjacentHTML('beforeend',
            `<p data-strfile="${file.json_file}">
                <a href="${file.url}" download="" target="_blank">
                    <i class="fa fa-file-pdf-o"></i>
                </a>
                <i class="delete_cross app_delete_cross_report"></i>
            </p>`
        );
    });
    parentEl.dataset.initialfiles = JSON.stringify(files);

    const hiddenInput = parentEl.querySelector('.app_report_certificates_json');
    if (hiddenInput) hiddenInput.value = JSON.stringify(files);
}

function spinnerStart(parentEl) {
    const spinner = parentEl.querySelector('.load_spinner');
    const cover   = parentEl.querySelector('.input_cover');
    if (spinner) spinner.style.display = 'flex';
    if (cover)   cover.style.display   = 'block';
}

function spinnerFinish(parentEl) {
    const spinner = parentEl.querySelector('.load_spinner');
    const cover   = parentEl.querySelector('.input_cover');
    if (spinner) spinner.style.display = 'none';
    if (cover)   cover.style.display   = 'none';
}
