export function toggleSignUpUserType() {
    const radios = document.querySelectorAll('input[name="user_human_id"]');
    const companyBlock = document.querySelector('.company_sigh_up');
    if (!companyBlock) return;
    radios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === '2') {
                companyBlock.classList.remove('display_none');
            } else {
                companyBlock.classList.add('display_none');
            }
        });
    });
}
