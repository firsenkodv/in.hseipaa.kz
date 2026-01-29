import {axiosLaravel} from "../axios/axiosLaravel";

export function checkCounterparty() {

const appCounterparty = document.querySelector('.app_counterparty');
if(appCounterparty){


    const appCpSend = appCounterparty.querySelector('.app_cp_send');
    appCpSend.addEventListener('click', () => {

        /** Включаем компонент loader **/
        const loader = appCounterparty.querySelector('.app_loader');
        loader.classList.toggle('active');

        /** убрать класс active **/
        appCounterparty.querySelector('.app_contr_wrap_result').classList.remove('active');

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
                        loader.classList.toggle('active');
                    } else {
                        /** если нет ошибок **/
                        console.log(result.check)
                        loader.classList.toggle('active');
                        const resultCheck = result.check;
                        const divResult = appCounterparty.querySelector('.app_counterparty_result');

                        /** добавить класс active **/
                        appCounterparty.querySelector('.app_contr_wrap_result').classList.add('active');
                        if(resultCheck){

                            // Получаем ВСЕ элементы с классом ".nameru"
                            const nameElements = divResult.querySelectorAll('.nameru');

                            // Заполняем каждое найденное значение
                            for(let el of nameElements){
                                el.innerHTML = resultCheck.nameru ?? '—';
                            }

                            divResult.querySelector('.bin').innerHTML = resultCheck.bin??'—'
                            divResult.querySelector('.b_rnn').innerHTML = resultCheck.b_rnn??'—'
                            divResult.querySelector('.b_okpo').innerHTML = resultCheck.b_okpo??'—'
                            divResult.querySelector('.namekz').innerHTML = resultCheck.namekz??'—'
                            divResult.querySelector('.addressru').innerHTML = resultCheck.addressru??'—'
                            divResult.querySelector('.director').innerHTML = resultCheck.director??'—'
                            divResult.querySelector('.okedru').innerHTML = resultCheck.okedru??'—'
                            divResult.querySelector('.krpName').innerHTML = resultCheck.krpName??'—'
                            divResult.querySelector('.okedCode').innerHTML = resultCheck.okedCode??'—'
                            divResult.querySelector('.krpCode').innerHTML = resultCheck.krpCode??'—'
                            divResult.querySelector('.katoCode').innerHTML = resultCheck.katoCode??'—'

                            const statusMap = {
                                1: 'Надежный',
                                2: 'Недостаточно информации для оценки надежности',
                                3: 'Ненадежный',
                            };

                            const status = resultCheck.status;
                           // Если status отсутствует в объекте, вернет пустую строку
                            divResult.querySelector('.app_status').classList.add('status'+status);
                            divResult.querySelector('.app_status').innerHTML = statusMap[status] || '';


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
