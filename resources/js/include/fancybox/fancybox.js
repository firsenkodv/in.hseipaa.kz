import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import {fancyboxExecution} from "./fancybox_execution";


/*Fancybox.bind('[data-fancybox]', {

    zoomEffect: false,
    hideScrollbar: false, // Оставляем скроллбар видимым
    dragToClose: false,
    clickOutside: false,
    preventViewportChange: true, // Добавьте эту опцию, чтобы предотвратить смену положения просмотра
    userSelectableContent: true, // Разрешаем выделять текст внутри модального окна
    touch: false,

});*/

/** получаем csrf **/
const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
const csrf = metaElements.length > 0 ? metaElements[0].content : "";
/** получаем csrf **/


const fancyWindows = Array.from(document.querySelectorAll('.open-fancybox'))

/** открыть open-fancybox **/
for (let fancyWindow of fancyWindows) {
    fancyWindow.addEventListener('click', openFancyBox)
}


async  function openFancyBox(e) {
    e.preventDefault()
    try {

        /** в случае клика по-внутреннему тэгу, получим data-form в любом случае **/
        const parentEl = e.target.closest('.open-fancybox');
        const formTemplate = parentEl.dataset.form; /** название шаблона для blade **/
        const template = { template: formTemplate, author: '@AxeldMaster' };

        console.log(template)

        const response = await fetch('/fancybox-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrf
            },
            body: JSON.stringify(template),
        });
        if (!response.ok) {
            console.error(`Error: ${response.status}`);
        }
        // const data = await response.json();
        const data = await response.text(); // Важно использовать .text(), а не .json()

        Fancybox.show([{
            html: data,

        }],
            {
            dragToClose: false,       // Перетаскивание не закроет модалку
            closeButton: true,         // Крестик закрытия включен
            backdropClick: false      // нельзя закрыть нажатием в свободную область
        },
            );


        fancyboxExecution() // соберем эту форму

    } catch (err) {
        console.error('Ошибка AJAX:', err.message);
        alert('Ошибка при получении данных');
    }
}
