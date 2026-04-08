import {axiosLaravel} from '../axios/axiosLaravel.js'

const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

export function uploadAvatar() {

    const avatars = document.querySelectorAll('.app_cu__avatar');

    avatars.forEach(cuAvatar => {

        const photoInput = cuAvatar.querySelector('input[type="file"]');

        if (!photoInput) return;

        const url       = cuAvatar.dataset.url || '/cabinet.upload.photo';
        const managerId = cuAvatar.dataset.managerid || '';
        const userId    = cuAvatar.dataset.userid    || '';

        photoInput.onchange = async function (e) {

            const file = e.target.files[0];

            if (!file) return alert('Выберите файл!');

            if (!allowedTypes.includes(file.type)) {
                return alert('Недопустимый формат файла. Разрешены: JPG, PNG, GIF, WEBP.');
            }

            try {
                const formData = new FormData();
                formData.append('avatar', file);
                if (managerId) formData.append('manager_id', managerId);
                if (userId)    formData.append('user_id', userId);

                axiosLaravel(formData, url)
                    .then((result) => {
                        if (result.errors) {
                            alert(result.errors.avatar);
                        } else {
                            cuAvatar.style.backgroundImage = 'url(' + result.intervention + ')';
                            const mw = cuAvatar.querySelector('.mw');
                            if (mw) mw.remove();
                        }
                    })
                    .catch((error) => { console.error(error); });

            } catch (err) {
                console.error(err.message);
            }
        };
    });
}
