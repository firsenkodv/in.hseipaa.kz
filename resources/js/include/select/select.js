export function select() {

    /** Инициализируем только ещё не инициализированные селекты **/
    const selects = Array.from(document.querySelectorAll('.select-box .selected:not([data-select-init])'));

    if (selects.length) {
        for (let selected of selects) {
            /** Помечаем элемент как инициализированный, чтобы не навешивать листенеры повторно **/
            selected.dataset.selectInit = 'true';

            const parentEl = selected.closest('.app_select_group');
            const optionsContainer = parentEl.querySelector(".options-container");
            const searchBox = parentEl.querySelector(".search-box input");
            const fieldName = parentEl.querySelector(".app_field_name");
            const optionsList = parentEl.querySelectorAll(".option");

            let activeIndex = 0;

            /** Фильтрация списка по поисковому запросу **/
            const filterList = searchTerm => {
                searchTerm = searchTerm.toLowerCase();
                optionsList.forEach(option => {
                    let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
                    option.style.display = label.indexOf(searchTerm) !== -1 ? "block" : "none";
                });
            };

            /** Переключение выделения стрелками **/
            function moveSelection(direction) {
                optionsList[activeIndex].classList.remove('active');
                activeIndex += direction;
                if (activeIndex >= optionsList.length) activeIndex = 0;
                if (activeIndex < 0) activeIndex = optionsList.length - 1;
                optionsList[activeIndex].classList.add('active');
                optionsList[activeIndex].focus();
            }

            /** Подтверждение выбора клавишей Enter **/
            function confirmSelection() {
                const label = optionsList[activeIndex].querySelector('label');
                selected.innerHTML = label.textContent;
                selected.classList.add('active');
                selected.classList.add('app_selected');
                if (fieldName !== null) {
                    fieldName.value = label.dataset.id;
                }
                optionsContainer.classList.remove('active');
            }

            /** Навигация по клавиатуре — регистрируется один раз **/
            optionsContainer.addEventListener('keydown', (event) => {
                switch (event.key) {
                    case 'ArrowDown':
                        event.preventDefault();
                        moveSelection(1);
                        break;
                    case 'ArrowUp':
                        event.preventDefault();
                        moveSelection(-1);
                        break;
                    case 'Enter':
                        confirmSelection();
                        break;
                }
            });

            /** Открытие / закрытие дропдауна **/
            selected.addEventListener("click", () => {
                searchBox.value = "";
                filterList("");

                if (optionsContainer.classList.contains('active')) {
                    /** закроем options **/
                    optionsContainer.classList.remove("active");
                } else {
                    /** откроем options и сфокусируем поиск **/
                    optionsContainer.classList.add("active");
                    searchBox.focus();
                }
            });

            /** Выбор одной из option **/
            function clickOption(e) {
                optionsContainer.querySelectorAll('.option').forEach(option => {
                    option.classList.remove('active');
                });

                const optionElement = e.currentTarget;
                optionElement.classList.add('active');

                const label = optionElement.querySelector('label');
                selected.innerHTML = label.textContent;
                selected.classList.add('active');
                selected.classList.add('app_selected');

                optionsContainer.classList.remove('active');

                if (fieldName !== null) {
                    fieldName.value = label.dataset.id;
                }
            }

            for (let option of optionsList) {
                option.addEventListener('click', clickOption);
            }

            searchBox.addEventListener("keyup", function (e) {
                filterList(e.target.value);
            });
        }
    }

}
