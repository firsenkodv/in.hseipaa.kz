export async  function fetchLaravel(array, url) {

    const metaElements = document.querySelectorAll('meta[name="csrf-token"]');
    const csrf = metaElements.length > 0 ? metaElements[0].content : "";

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': csrf
                },
                body: JSON.stringify(array),
            });     // делаем запрос
            if (response.ok) {                            // проверяем статус ответа
                const data = await response.json();        // ждём преобразования JSON
               // console.log(data.response);                // работаем с результатом
                return data;

            } else {
                console.error(`Error: ${response.status}`);

            }
        } catch (e) {
            console.error(response); // запрос не прошел
            return 'Запрос не прошел';
        }

}
