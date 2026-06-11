//todo:jquery
export function imask() {

    const phone = document.querySelectorAll('.imask');
    const maskOptions = {
        mask: [
            { mask: '+{7}(000)000-00-00' },  // +7 (RU, KZ) — 11 цифр
            { mask: '+000(000)000-000'   },  // +996 и др. — 12 цифр
        ],
        dispatch: function(appended, dynamicMasked) {
            var number = (dynamicMasked.value + appended).replace(/\D/g, '');
            if (number.startsWith('7')) {
                return dynamicMasked.compiledMasks[0];
            }
            return dynamicMasked.compiledMasks[1];
        }
    };
    for (var i = 0; i < phone.length; i++) {
        new IMask(phone[i], maskOptions);
    }

}

export function imask_price() {
    const elem = document.querySelector('input[name="price"]');
    if (elem) {
        new IMask(elem, {
            mask: Number,
            thousandsSeparator: ' ',
            min: 0,
            scale: 0,
            signed: false,
        });
    }
}

export function imask_hours() {
    const elem = document.querySelector('input[name="hours"]');
    if (elem) {
        new IMask(elem, {
            mask: Number,
            min: 1,
            max: 400,
            scale: 0,
            signed: false,
        });
    }
}
