import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import {asyncExecution} from "../form_async/async_execution";
import {scrollCabinetMessages} from "./cabinet_message";
import {datepicker_contract_period} from "../datepicker/datepicker";


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


/** обновление строки дисциплины после сохранения **/
document.addEventListener('form:success', (e) => {
    const data = e.detail;
    if (!data) return;

    if (data.contract_created && data.user_id) {
        const container = document.getElementById('js-user-contracts');
        if (container) {
            fetch(`/cabinet-administrator/ajax/user-contracts/${data.user_id}`, {
                headers: { 'X-CSRF-TOKEN': csrf },
            })
            .then(r => r.text())
            .then(html => {
                container.innerHTML = html;
                const first = container.querySelector('.user-contracts__item');
                if (first) first.style.background = 'rgba(254, 82, 68, 0.08)';
            });
        }
    }

    if (data.training_id !== undefined) {
        const row = document.querySelector(`.training-list [data-training-id="${data.training_id}"] .username`);
        if (row) row.textContent = data.title;
    }

    if (data.contract_id !== undefined && !data.signed) {
        const item = document.querySelector(`.user-contracts__item[data-contract-id="${data.contract_id}"]`);
        if (!item) return;
        const get = (f) => item.querySelector(`[data-contract-field="${f}"]`);
        if (get('discipline')) get('discipline').textContent = data.discipline;
        if (get('period'))     get('period').textContent     = `${data.date_start} — ${data.date_end}`;
        if (get('price'))      get('price').textContent      = data.price;
        if (get('currency'))   get('currency').textContent   = data.currency;
        if (get('hours'))      get('hours').textContent      = data.hours;
    }

    if (data.contract_id !== undefined && data.signed) {
        const item = document.querySelector(`.user-contracts__item[data-contract-id="${data.contract_id}"]`);
        if (!item) return;

        item.classList.add('user-contracts__item--signed');

        const pending = item.querySelector('.user-contracts__badge--pending');
        if (pending) {
            pending.classList.replace('user-contracts__badge--pending', 'user-contracts__badge--signed');
            pending.textContent = 'Подписан';
        }

        const signBtn = item.querySelector('.user-contracts__sign-btn');
        if (signBtn) signBtn.remove();
    }
});

/** копирование ссылки на договор **/
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.user-contracts__copy-btn');
    if (!btn) return;

    const url = btn.dataset.copyUrl;
    if (!url) return;

    navigator.clipboard.writeText(url).then(() => {
        const iconCopy  = btn.querySelector('.icon-copy');
        const iconCheck = btn.querySelector('.icon-check');
        iconCopy.style.display  = 'none';
        iconCheck.style.display = '';
        setTimeout(() => {
            iconCopy.style.display  = '';
            iconCheck.style.display = 'none';
        }, 1500);
    });
});
/** /// копирование ссылки на договор **/

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
        const transferData = parentEl.dataset.transfer; /** дополнительные данные в json для blade **/
        const template = { template: formTemplate, author: '@AxeldMaster', data: transferData };

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
            backdropClick: 'close'    // закрыть нажатием в свободную область
        },
            );


        asyncExecution();       // соберем эту форму
        scrollCabinetMessages(); // скроллим до последнего сообщения
        datepicker_contract_period(); // инициализация датапикера периода договора

    } catch (err) {
        console.error('Ошибка AJAX:', err.message);
        alert('Ошибка при получении данных');
    }
}
