export async  function fetchLaravel(array, url) {

    /** получаем csrf **/
    const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
    const csrf = metaElements.length > 0 ? metaElements[0].content : "";
    /** получаем csrf **/

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrf
                },
                body: JSON.stringify(array),
            });     // делаем запрос

          //  console.error(`status: ${response.status}`);
          //  console.error(`error: ${response.error}`);

            if (response.ok) {                            // проверяем статус ответа
                const data = await response.json();        // ждём преобразования JSON
               // console.log(data.response);                // работаем с результатом
                return data;

            } else {
                console.error(`status: ${response.status}`);
            }

            console.error(`Error: ${response.error}`);


        } catch (error) {


            console.log(`Error: ${error}`);

/*
           // console.log(err.message);
            let message = err.message || '';
            if (err instanceof SyntaxError && err.name === 'SyntaxError') {
                // Если ошибка парсинга JSON
                message += ', invalid JSON received';
            } else if (err.response?.data.errors) {
                // Если были валидные ошибки от Laravel
                message = Object.values(err.response.data.errors).flat().join(', ');
            }


            throw new Error(message);*/
        }

}
