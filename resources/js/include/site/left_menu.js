import {animateCSS} from "../animateCSS";
export function left_menu() {
// animateCSS('.submenu.active', 'animate__fadeIn');

    const appLeftArrow = Array.from(document.querySelectorAll('.left_menu .app_left_arrow'))
    /** получим все возможные галочки в меню **/
    for (let arrow of appLeftArrow) {
        arrow.addEventListener('click', arrowToggle)
    }

    function arrowToggle(e) {
        const parentEl = e.target.closest('.parent');
        const subMenu = parentEl.querySelector('.submenu');



            if (!subMenu.classList.contains('active')) {
                // Получаем высоту содержимого перед открытием
                subMenu.style.height = `${subMenu.scrollHeight}px`;
                subMenu.classList.add('active'); // Добавляем класс active

            } else {
                subMenu.classList.remove('active');
                subMenu.style.height = '0';
            }




    }
}
