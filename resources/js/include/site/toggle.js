import {fetchLaravel} from './fetch/fetchLaravel';

export function toggle_cities() {


    const app_phone_rack = document.querySelector('.app_phone_rack')
    const app_city_rack = document.querySelector('.app_city_rack')
    const app_cities_list__ul = document.querySelector('.app_cities_list__ul')
    const app_arrow_top_bottom = document.querySelector('.app_arrow_top_bottom')
    const app_cities_select = Array.from(document.querySelectorAll('.app_city_select'))

    /** Начинаем показ элементов - Города **/
    app_city_rack.addEventListener('click', Cities)

    /** скрываем города при клике в любое место **/
    document.addEventListener('click', Close, true)

    /** Выбрать город из списка и поставить его на видное место  **/
    for (let city of app_cities_select) {
        city.addEventListener('click', SelectCityFetch)
    }

    /************************************************* ******************************************************/
    /************************************************* ******************************************************/

    function Cities() {

        // Подождём немного перед проверкой классов
        setTimeout(() => {
            app_cities_list__ul.classList.toggle('active')
            app_arrow_top_bottom.classList.toggle('active');

        }, 10); // задержка в миллисекундах

      }

    function Close(e) {

        //console.log(e.target.className);
        if (document.querySelector('.app_cities_list__ul.animate__fadeInDown')) {
            // Проверяем, попал ли клик внутрь нашего элемента
            if (!e.target.closest('.app_cities_list__ul') && (e.target.className !== 'app_city_rack')) {
                // Клик пришел извне, скрываем элемент или по app_city_rack
                app_cities_list__ul.classList.remove('active');
                app_arrow_top_bottom.classList.remove('active');

            }

        }
    }




     function SelectCity(e) {
        /** не используется **/
         // Вариант установки
         app_city_rack.innerHTML = e.target.textContent.trim();
         const parentEl = e.target.closest('.city_li');
         const childElement = parentEl.querySelector('.city_tel');
       if(childElement) {
               app_phone_rack.innerHTML = childElement.textContent.trim();
               // устанавливаем новый URL
               app_phone_rack.href = 'tel:' + childElement.textContent.trim();
           }
         /** не используется **/
     }
     function SelectCityFetch(e) {

        const parentEl = e.target.closest('.city_li');
        const childElement = parentEl.querySelector('.city_tel');


        /**  отправка на сервер данных **/
        const url = '/set.city.default';
        const arrayToSend = {
            title: e.target.textContent.trim(),
            phone: childElement.textContent.trim()
        }
         // Выполняем запрос и ждем результата
         fetchLaravel(arrayToSend, url)
             .then((result) => {
                /** console.log(result); // Работа с результатом **/
                if(result.city_phone) {
                    /** Пришел телефон **/
                    app_phone_rack.innerHTML = childElement.textContent.trim();
                    app_phone_rack.href = 'tel:' + result.city_phone;
                }
                if(result.city_title) {
                    /** Пришел город **/
                    app_city_rack.innerHTML = result.city_title;
                }

                 app_cities_list__ul.classList.remove('active')


             })
             .catch((err) => {
                /** console.error(err); // Обрабатываем возможные ошибки **/
             });
    }



}
