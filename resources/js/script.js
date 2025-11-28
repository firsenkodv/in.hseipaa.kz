import { imask } from './include/imask';
import { close_flash } from './include/flash';
/*import {tooltip} from './include/tooltip';*/
import {toggle_cities} from './include/site/toggle';
import {hamburger} from "./include/site/hamburger";
import {yandex_map_object} from "./include/site/yandex_map";
import {left_menu} from "./include/site/left_menu";
import {tax_calendar} from "./include/site/tax_calendar";
import {swiper} from "./include/site/swiper";
import {content_faq} from "./include/site/content_faq.js";
import {mobileMenuComponent} from "./include/site/mobile/mobile-menu-component.js";



document.addEventListener('DOMContentLoaded', function () {


    imask() // маска на поле input input[name="phone"]
    close_flash() // закрытие flash
   /* tooltip() // tooltip */
    toggle_cities() // переключатель городов с запросом
    hamburger() // открытие и закрытие верхнего меню
    yandex_map_object('43db27ba-be61-4e84-b139-ff37ad4802b8') // карта в объект
    left_menu() // левое меню
    tax_calendar() // налоговый календарь
    swiper()
    content_faq() // FAQ
    mobileMenuComponent() // мобильное меню


});
