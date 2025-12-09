import { slideToggle } from '../methods/slideToggle';

export function content_faq() {
    const appTrs = Array.from(document.querySelectorAll('.app_tr'))

    /** Выбрать заголовок вопроса  **/
    for (let tr of appTrs) {
        tr.addEventListener('click', clickTitle)
    }

    function clickTitle(e) {

        const parentEl = e.target.closest('.app_tr');
        parentEl.classList.toggle('active');
        slideToggle(parentEl.querySelector('.app_answer'), 400);
    }

}
