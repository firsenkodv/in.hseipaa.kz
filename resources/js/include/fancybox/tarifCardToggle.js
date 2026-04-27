export function tarifCardToggle() {
    document.addEventListener('click', (e) => {
        const card = e.target.closest('.ms_tarif_card');
        if (!card) return;

        const list = card.closest('.ms_tarif_list');
        if (!list) return;

        list.querySelectorAll('.ms_tarif_card').forEach(c => c.classList.remove('is-selected'));
        card.classList.add('is-selected');

        const input = document.getElementById('js_tarif_selected');
        if (input) input.value = card.dataset.id;
    });
}
