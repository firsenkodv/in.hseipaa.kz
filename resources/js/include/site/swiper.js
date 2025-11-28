// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';

export function swiper() {

// init Swiper:
    const swiper = new Swiper('.swiper', {
        loop: true,


        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },


    });
}
