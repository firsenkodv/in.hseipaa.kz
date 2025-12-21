import {axiosLaravel} from '../axios/axiosLaravel.js'


export function uploadAvatar() {
    const cuAvatar = document.querySelector('.app_cu__avatar');
    const photoInput = document.getElementById('photoInput');
    if (photoInput) {
        photoInput.onchange = async function (e) {
            const file = e.target.files[0];  // Получаем выбранный файл

            // Проверяем наличие выбранного файла
            if (!file) return alert("Выберите файл!");

            try {
                const formData = new FormData();  // Формируем объект FormData

                // Добавляем файл в FormData
                formData.append('avatar', file);

                /** Выполняем запрос и ждем результата **/

                const url = '/cabinet.upload.photo';
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
                    .catch((error) => {


                    });
            } catch (err) {
                console.error(err.response.data || err.message);
            }
        };
    }
}
