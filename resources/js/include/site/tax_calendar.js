export function tax_calendar() {

    const quarters = Array.from(document.querySelectorAll('.quarters .app_quarter'))
    const mounts3 = Array.from(document.querySelectorAll('.mounts .app_mounts'))
    const mounts = Array.from(document.querySelectorAll('.mounts .app_mount'))
    const q_none = Array.from(document.querySelectorAll('.tax-contents .q_none'))

    /** получим все возможные кварталы **/
    for (let quarter of quarters) {
        quarter.addEventListener('click', setQuarter)
    }

    function setQuarter(e) {

        /** переключаем кварталы **/
        for (let q of quarters) {
            q.classList.remove('active')
        }
        let selectedQuarter = e.target.dataset.quarter; //
        e.target.classList.add('active')

        /** переключаем 3 месяца  **/
        for (let m3 of mounts3) {
            m3.classList.remove('active')
        }
        const quarter = document.querySelector('.' + selectedQuarter)
        quarter.classList.add('active')

        /** переключаем месяцы делаем активным первый  **/
        for (let m of mounts) {
            m.classList.remove('active')
        }
        const mount = document.querySelector('.m_' + selectedQuarter)
        mount.classList.add('active')

        /** удаляем все записи всех месяцев **/
        for (let q_n of q_none) {
            q_n.classList.remove('active')
        }
        const dataMount = document.querySelector('.d_' + selectedQuarter)
        dataMount.classList.add('active')

//console.log(selectedQuarter)
    }


    for (let mount of mounts) {
        mount.addEventListener('click', setMount)
    }

    function setMount(e) {
        let selectedMonth = e.target.dataset.month; //

        /** удалим активность у всех месяцев **/
        for (let m of mounts) {
            m.classList.remove('active')
        }

        /** поставим активным  **/
        e.target.classList.add('active');

        /** удаляем все записи всех месяцев **/
        for (let q_n of q_none) {
            q_n.classList.remove('active')
        }
        const dataMount = document.querySelector('.' + selectedMonth)
        dataMount.classList.add('active')
    }


    window.onload = () => {
        // Получаем элементы контейнера и активный месяц
        const container = document.querySelector('.output_calendar__module ');
        const activeMonth = document.querySelector('.output_calendar__module .super');


        // Проверяем существование элемента
        if (activeMonth && container) {

            // Рассчитываем позицию элемента относительно контейнера
            const topPosition = activeMonth.offsetTop + container.scrollTop - container.clientTop;
            container.scrollTo({
                top: topPosition,
                behavior: 'smooth',
                block: 'start'
            });


            // console.log(container)
            // console.log(activeMonth)
            // console.log(topPosition)

        }
    };


}
