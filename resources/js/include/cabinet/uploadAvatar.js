import {axiosLaravel} from '../axios/axiosLaravel.js'


export function uploadAvatar() {
    const cuAvatar = document.querySelector('.app_cu__avatar');
    const photoInput = document.getElementById('photoInput');

let url, managerId, userId;
    if(cuAvatar) {
    console.log('cuAvatar')
         url = cuAvatar.dataset.url;
         managerId = cuAvatar.dataset.managerid;
         userId = cuAvatar.dataset.userid;
    }

    if (photoInput) {
        photoInput.onchange = async function (e) {
            console.log('photoInput')
            const file = e.target.files[0];  // Получаем выбранный файл
            // Проверяем наличие выбранного файла
            if (!file) return alert("Выберите файл!");

        try {
                const formData = new FormData();  // Формируем объект FormData

                // Добавляем файл в FormData
                formData.append('avatar', file);
                (managerId !== '') ?  formData.append('manager_id', managerId) : false;
                (userId !== '') ?  formData.append('user_id', userId) : false;

                /** Выполняем запрос и ждем результата **/
            url = (url !== '') ? url : '/cabinet.upload.photo';
                // Проверка: если url ложное (undefined, null, пустая строка), используем дефолт
             //   url = url || '/cabinet.upload.photo';

                axiosLaravel(formData, url)
                    .then((result) => {

                        if (result.errors) {

                            alert(result.errors.avatar)

                        } else {
                            /** если нет ошибок **/
                            console.log(result.avatar)
                            const intervention = result.intervention;
                            console.log(intervention);
                            cuAvatar.style.backgroundImage = 'url('+ intervention +')';
                            cuAvatar.querySelector('.mw').remove()

                            // cuAvatar.style = 'img'


                        }


                    })
                    .catch((error) => { console.error(error); });
           } catch (err) {
                console.error(err.response.data || err.message);
            }
        };
    }
}
