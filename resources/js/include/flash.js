export function close_flash() {

    const closeFModal = document.querySelector('.app_add_hm')

    closeFModal.addEventListener('click', CloseModal)

    function CloseModal(e) {
        const parentEl = e.target.closest('.flashMassege');
        parentEl.remove();
    }
/*    $('body').on('click', '.flashClose__js', function (event) {
        $(this).parents('.flashMassege').slideUp(100);
    });*/

}
