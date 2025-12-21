export function select() {

    const selects = Array.from(document.querySelectorAll('.select-box .selected'))
    console.log(selects)
    if(selects.length) {
        /** получим все возможные selected (типа вывод select` а) на всех формах **/
        for (let selected of selects) {
            /** получим главного родителя **/
            const parentEl = selected.closest('.app_select_group');
            /** получим options **/
            const optionsContainer = parentEl.querySelector(".options-container");
            /** получим поиск **/
            const searchBox = parentEl.querySelector(".search-box input");

            /** получим input в который будем записывать результат (есть не везде)  **/
            const fieldName = parentEl.querySelector(".app_field_name");

            /** все options **/
            const optionsList = parentEl.querySelectorAll(".option");
            for (let option of optionsList) {
                option.addEventListener('click', clickOption)
            }


            selected.addEventListener("click", () => {


                 searchBox.value = "";
                filterList("");

                if (optionsContainer.classList.contains('active')) {

                    /** закроем options **/
                    optionsContainer.classList.remove("active");
                    /** когда открыты options фокусируем поиск **/
                    searchBox.focus();
                } else {

                    /** откроем options **/
                    optionsContainer.classList.add("active");
                }


                // Текущий индекс активной опции
                let activeIndex = 0;


                // Навигация по кнопкам
                optionsContainer.addEventListener('keydown', (event) => {

                    switch (event.key) {
                        case 'ArrowDown':
                            event.preventDefault(); // Предотвращаем прокрутку страницы
                            moveSelection(1);       // Переход на следующую строку
                            break;
                        case 'ArrowUp':
                            event.preventDefault(); // Предотвращаем прокрутку страницы
                            moveSelection(-1);      // Переход на предыдущую строку
                            break;
                        case 'Enter':               // Нажали Enter, выбираем активную опцию
                            confirmSelection();
                            break;
                    }
                });


                // Переключение выделения
                function moveSelection(direction) {
                    // Убираем активный класс у предыдущего элемента
                    optionsList[activeIndex].classList.remove('active');

                    // Изменяем индекс
                    activeIndex += direction;

                    // Ограничиваем диапазон индексов
                    if (activeIndex >= optionsList.length) activeIndex = 0;
                    if (activeIndex < 0) activeIndex = optionsList.length - 1;

                    // Устанавливаем новый активный элемент
                    optionsList[activeIndex].classList.add('active');

                    // Автоматически устанавливаем фокус на новом элементе
                    optionsList[activeIndex].focus();
                }

// Активируем выбранный пункт
                function confirmSelection() {
                    const selectedLabel = optionsList[activeIndex].querySelector('label').textContent;
                    customSelect.querySelector('.selected').textContent = selectedLabel;
                    optionsContainer.classList.remove('active');
                }

// Устанавливаем начальный фокус на первом пункте
                optionsList[0].focus();
            });


            /** выбор одной из option **/
            function clickOption(e) {

                /** Получаем все элементы .option внутри .options-container **/
                const options = optionsContainer.querySelectorAll('.option');

                /** Перебираем все элементы и удаляем класс active **/
                options.forEach(option => {
                    option.classList.remove('active');
                });

                /** Получаем ближайший родительский элемент .option **/
                const optionElement = e.currentTarget;
                /** сделаем его активным **/
                optionElement.classList.add('active')
                /** Выбираем первый попавшийся элемент <label> внутри .option **/
                const label = optionElement.querySelector('label');
                /** Берём текст из <label> **/
                const text = label.textContent;
                // console.log(text);
                selected.innerHTML = text; // записываем результат
                optionsContainer.classList.remove('active');
                selected.classList.add('active')
                selected.classList.add('app_selected')

                 /** если есть поле, для записи результата селекта **/
                if (fieldName !== null) {
                    fieldName.value = label.dataset.id
                }


                }


            searchBox.addEventListener("keyup", function (e) {
                filterList(e.target.value);
            });

            const filterList = searchTerm => {
                searchTerm = searchTerm.toLowerCase();
                optionsList.forEach(option => {
                    let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
                    if (label.indexOf(searchTerm) != -1) {
                        option.style.display = "block";
                    } else {
                        option.style.display = "none";
                    }
                });
            };


        }
    }

}
