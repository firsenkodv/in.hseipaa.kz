import {scrf} from "../csrf";
import {axiosLaravel} from '../axios/axiosLaravel'

export function uploadFiles() {
    const takeSaves = Array.from(document.querySelectorAll('.app_take__save'));

    if (takeSaves.length) {
        for (let takeSave of takeSaves) {
            takeSave.onchange = async function (e) {
                const parentEl = e.target.closest(".app_input-file");
                /** start spinner **/
                loadSpinnerStart(parentEl);

                // Получаем существующие файлы из initialFiles
                const initialFilesRaw = parentEl.dataset.initialfiles;
                const existingFiles = initialFilesRaw && initialFilesRaw !== '' ? JSON.parse(initialFilesRaw) : [];
                // имя поля
                const fieldName = e.target.name
                //console.log(existingFiles);

                // Получаем выбранные файлы
                let selectedFiles = e.target.files;

                // Проверка максимального размера файла (15MB ≈ 15728640 bytes)
                for (let i = 0; i < selectedFiles.length; i++) {
                    if (selectedFiles[i].size > 15728640) {
                        alert(`Размер файла "${selectedFiles[i].name}" превышает 15 MB.`);
                        /** finish spinner **/
                        loadSpinnerFinish(parentEl)
                        return false;
                    }
                }

                // Лимит на общее число файлов — 4 штуки
                if (
                    existingFiles.length + selectedFiles.length > 4 ||
                    selectedFiles.length > 4
                ) {
                    alert("Всего можно загрузить до 4 файлов.");
                    /** finish spinner **/
                    loadSpinnerFinish(parentEl)
                    return false;
                }

                let formData = new FormData();
                Array.from(selectedFiles).forEach((file, index) => {
                    formData.append(`files[${index}]`, file);
                });

                formData.append("field_name", fieldName); // Добавляем имя поля
                const url = '/cabinet.upload.files';

                axiosLaravel(formData, url)
                    .then((response) => {

                        if (response.success) {
                            /** Обрабатываем результат
                             /** Объединяем оба массива **/
                            const combinedFiles = [...existingFiles, ...response.files];
                            /** Берём первые четыре файла **/
                            const updatedFiles = combinedFiles.slice(0, 4);
                            //  console.log(updatedFiles);

                            /** Обновляем контейнер **/
                            const uploadedContainer = parentEl.querySelector(".uploadedFiles");
                            uploadedContainer.innerHTML = "";
                            updatedFiles.forEach((file) => {
                                //   console.log(file)
                                const fileLink = `<a href="${file.url}" download="" target="_blank"><i class="fa ${getFileTypeIcon(file.extension)}"></i></a><i class="delete_cross app_delete_cross" ></i>`;
                                uploadedContainer.insertAdjacentHTML("beforeend", `<p data-strfile="${file.json_file}">${fileLink}</p>`);
                            });

                            /** Обновляем данные в DOM **/
                            parentEl.dataset.initialfiles = JSON.stringify(updatedFiles);

                            /** получение и удаление файлов, в том числе и только что загруженные **/
                            gettingAndDeletingFiles()
                            /** finish spinner **/
                            loadSpinnerFinish(parentEl)


                        } else {
                            console.error("Ошибка загрузки:", response.message);
                            /** finish spinner **/
                            loadSpinnerFinish(parentEl)

                            /** получение и удаление файлов, в том числе и только что загруженные **/
                            gettingAndDeletingFiles()


                        }


                    })
                    .catch((error) => {

                        console.log(error)
                    });


            };
        }
    }

    function gettingAndDeletingFiles() {
    //const deleteButtons = Array.from(document.querySelectorAll('.app_delete_cross'));

        // Назначаем прослушивать на общий родительский контейнер
        const uploadedContainers = Array.from(document.querySelectorAll('.uploadedFiles'));


        if (uploadedContainers.length) {

            for (let uploadedContainer of uploadedContainers) {
                uploadedContainer.addEventListener('click', deleteFiles);


                async function deleteFiles(e) {


                    // Проверяем, кликнули ли по нужной кнопке
                    if (e.target.matches('.app_delete_cross')) {
                        // Кликнули по крестику удаления
                        const parentParagraph = e.target.closest('p');
                        // элемент для удаления

                        const strFile = parentParagraph.dataset.strfile;
                        const parentEl = e.target.closest('.app_input-file');

                        // имя поля
                        const fieldName = parentEl.querySelector('.app_take__save').name;

                        // Далее ваша логика обработки удаления файла
                        // (например, формирование запроса на сервер и обновление UI)

                        console.log('Файл:', strFile, ', поле:', fieldName);


                        /** start spinner **/
                        loadSpinnerStart(parentEl);


                        let formData = new FormData();
                        const token = scrf();
                        formData.append("_token", token); // Добавляем токен сюда
                        formData.append("field_name", fieldName); // Добавляем имя поля
                        formData.append("field_value", strFile); // Добавляем элемент массива для удаления
                        const urlDel = '/cabinet.delete.files';

                        axiosLaravel(formData, urlDel)
                            .then((response) => {

                                if (response.success) {

                                    /** сюда приходит готовый массив - response.files **/
                                    const updatedFiles = response.files;

                                    /** получаем контейнер **/
                                    const uploadedContainer = parentEl.querySelector(".uploadedFiles");

                                    /** записываем новые файлы в контейнер и в dataset.initialfiles **/
                                    getNewArray(updatedFiles, uploadedContainer, parentEl)

                                    /** finish spinner **/
                                    loadSpinnerFinish(parentEl)

                                } else {

                                 //   alert('Ошибка удаления')
                                    console.error("Ошибка удаления:", response.error);

                                    /** finish spinner **/
                                    loadSpinnerFinish(parentEl)
                                }


                            })
                            .catch((error) => {
                                console.log(error)
                            });
                    }
                }
            }
        }
    }

    /** Функция для заполнения новыми файлами контейнера **/
    function getNewArray(updatedFiles, uploadedContainer, parentEl) {
        uploadedContainer.innerHTML = "";

        updatedFiles.forEach((file) => {
            const fileLink = `<a href="${file.url}" download="" target="_blank"><i class="fa ${getFileTypeIcon(file.extension)}"></i></a><i class="delete_cross app_delete_cross"></i>`;
            uploadedContainer.insertAdjacentHTML("beforeend", `<p data-strfile="${file.json_file}">${fileLink}</p>`);
        })
        // Обновляем данные в DOM
        parentEl.dataset.initialfiles = JSON.stringify(updatedFiles);
    }

    /** Функция для получения иконки файла **/
    function getFileTypeIcon(extension) {
        switch (extension) {
            case "jpg":
            case "jpeg":
            case "png":
            case "gif":
                return "fa-file-image-o";
            case "pdf":
                return "fa-file-pdf-o";
            case "doc":
            case "docx":
                return "fa-file-word-o";
            default:
                return "fa-file-o";
        }
    }

    function loadSpinnerStart(parentEl) {
        /** получим spinner **/
        const loadSpinner = parentEl.querySelector('.load_spinner')
        loadSpinner.style.display = 'flex';
        /** получим cover (покрывало) **/
        const loadCover = document.querySelector('.download_files__cover')
        loadCover.style.display = 'block';


    }

    function loadSpinnerFinish(parentEl) {
        /** получим spinner **/
        const loadSpinner = parentEl.querySelector('.load_spinner')
        loadSpinner.style.display = 'none';
        /** получим cover (покрывало) **/
        const loadCover = document.querySelector('.download_files__cover')
        loadCover.style.display = 'none';


    }

    /** получение и удаление файлов **/
    gettingAndDeletingFiles()
}
