import {Datepicker, DateRangePicker} from 'vanillajs-datepicker';
import ru from 'vanillajs-datepicker/locales/ru';

Object.assign(Datepicker.locales, ru);

export function topPositionLabel(elem) {
    // Обработчик события изменения даты
    elem.addEventListener('changeDate', function (event) {
        console.log(elem)
        const parentEl = elem.closest('.input-date-picker')
        const label = parentEl.querySelector('label')
        label.classList.add('position_top')

    });
}

export function datepicker_date_birthday() {

    const elem = document.querySelector('input[name="date_birthday"]');
    if(elem) {
        const today = new Date(); // Получаем сегодняшнюю дату
        today.setFullYear(today.getFullYear() - 18); // Отнимаем 18 лет
        const datepicker = new Datepicker(elem, {
            title:'Дата рождения',
            language: 'ru',
            format: 'dd.mm.yyyy',
            minDate: '01.01.1950',
            maxDate: today.toLocaleDateString(),
        });
        topPositionLabel(elem)
    }
}
export function datepicker_accountant_ticket_date() {

        const elem = document.querySelector('input[name="accountant_ticket_date"]');
        if (elem) {
            const today = new Date(); // Получаем сегодняшнюю дату
            const datepicker = new Datepicker(elem, {
                title: 'Дата выдачи сертификата',
                language: 'ru',
                format: 'dd.mm.yyyy',
                minDate: '01.01.1950',
                maxDate: today.toLocaleDateString(),

            });
            topPositionLabel(elem)

        }
}

export function datepicker_contract_period() {
    const wrapper = document.getElementById('contract-period');
    if (wrapper) {
        const rangePicker = new DateRangePicker(wrapper, {
            language: 'ru',
            format: 'dd.mm.yyyy',
            autohide: true,
        });

        const inputs = wrapper.querySelectorAll('input');
        const dateFrom = inputs[0]?.dataset.date;
        const dateTo   = inputs[1]?.dataset.date;
        if (dateFrom && dateTo) {
            const parse = (s) => { const [d, m, y] = s.split('.'); return new Date(y, m - 1, d); };
            rangePicker.setDates(parse(dateFrom), parse(dateTo));
        }

        inputs.forEach(function(elem) {
            topPositionLabel(elem);
        });
    }
}

export function datepicker_specialist_certificate_dates() {
    const elems = document.querySelectorAll('input[data-role="specialist-cert-date"]');
    if (!elems.length) return;

    const today = new Date();
    elems.forEach(function (elem) {
        const datepicker = new Datepicker(elem, {
            title: 'Дата выдачи сертификата',
            language: 'ru',
            format: 'dd.mm.yyyy',
            minDate: '01.01.1950',
            maxDate: today.toLocaleDateString(),
        });

        const dateVal = elem.dataset.date;
        if (dateVal) {
            const parts = dateVal.split('.');
            if (parts.length === 3) {
                const parsed = new Date(parseInt(parts[2]), parseInt(parts[1]) - 1, parseInt(parts[0]));
                datepicker.setDate(parsed);
            }
        }

        topPositionLabel(elem);
    });
}

export function datepicker_report_period() {
    const wrapper = document.getElementById('report-period');
    if (wrapper) {
        const rangePicker = new DateRangePicker(wrapper, {
            language: 'ru',
            format: 'dd.mm.yyyy',
            autohide: true,
        });

        const inputs = wrapper.querySelectorAll('input');
        const dateFrom = inputs[0]?.dataset.date;
        const dateTo   = inputs[1]?.dataset.date;
        if (dateFrom && dateTo) {
            const parse = (s) => { const [d, m, y] = s.split('.'); return new Date(y, m - 1, d); };
            rangePicker.setDates(parse(dateFrom), parse(dateTo));
        }

        inputs.forEach(function(elem) {
            topPositionLabel(elem);
        });
    }
}
