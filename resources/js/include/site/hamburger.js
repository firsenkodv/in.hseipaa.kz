export function hamburger() {

    const app_h_toggle = document.querySelector('.app_h_toggle')
    const app_h_open = document.querySelector('.app_h_open')
    const app_h_close = document.querySelector('.app_h_close')
    const app_add_hm = document.querySelector('.app_add_hm')

    app_h_toggle.addEventListener('click', openMenu)


    function openMenu(){
        if(app_h_open.classList.contains('active')) {
            app_h_open.classList.remove('active')
            app_h_close.classList.add('active')
            app_add_hm.classList.add('active')
        } else {
            app_h_open.classList.add('active')
            app_h_close.classList.remove('active')
            app_add_hm.classList.remove('active')

        }
    }


}
