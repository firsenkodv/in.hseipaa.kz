import {axiosLaravel} from "../axios/axiosLaravel";

export function checkCounterparty() {

const appCounterparty = document.querySelector('.app_counterparty');
if(appCounterparty){


    const appCpSend = appCounterparty.querySelector('.app_cp_send');
    appCpSend.addEventListener('click', () => {


        let sValue =  appCounterparty.querySelector('input');
        if(sValue.value.length > 3) {
            appCpSend.classList.add('d-none');
            appCpSend.setAttribute('disabled', 'true'); // устанавливаем атрибут disabled


            const formData = new FormData();  // Формируем объект FormData
            // Добавляем файл в FormData
            formData.append('search', sValue.value);
            const url = '/check.counter.party'; // URL для отправки данных

            axiosLaravel(formData, url)
                .then((result) => {

                    if (result.errors) {

                        //alert(result.errors)
                        appCpSend.classList.remove('d-none');

                    } else {
                        /** если нет ошибок **/
                        console.log(result.check)
                        const resultCheck = result.check;
                        const divResult = appCounterparty.querySelector('.app_counterparty_result');
                        if(resultCheck){
                            divResult.querySelector('.h3_mod').innerHTML = resultCheck.nameru
                        }

                        appCpSend.classList.remove('d-none');
                        appCpSend.removeAttribute('disabled'); // удаляем атрибут disabled


                        // cuAvatar.style = 'img'


                    }


                })
                .catch(() => {
                });
        } // if
    })


}


}
