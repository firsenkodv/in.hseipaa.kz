export function searchUser() {

    const search = document.getElementById("app_show_users");
    if (!search) return;
        search.addEventListener("click", () => {
            const el = document.querySelector('.app_select .option.active label');
            const dataId = el ? el.dataset.id : false;
            if (dataId) {
                const form = document.createElement("form");
                form.method = "GET";
                form.action = "/cabinet-rop/users/search";
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "id";
                input.value = dataId;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit(); // имитация отправки
            } else {
                alert('Выбрать менеджера')
            }
        });


}
export function assignUser() {
    const btn = document.getElementById("app_change_manager");
    if (!btn) return;

    btn.addEventListener("click", () => {
        const el = document.querySelector('.app_select .option.active label');
        const managerId = el ? el.dataset.id : false;

        if (!managerId) {
            alert('Выберите менеджера');
            return;
        }

        const checked = document.querySelectorAll(".checkbox_change:checked");
        if (!checked.length) {
            alert('Выберите пользователей');
            return;
        }

        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/cabinet-rop/users/assign";

        const token = document.createElement("input");
        token.type = "hidden";
        token.name = "_token";
        token.value = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        form.appendChild(token);

        const manager = document.createElement("input");
        manager.type = "hidden";
        manager.name = "id";
        manager.value = managerId;
        form.appendChild(manager);

        checked.forEach(cb => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "users[]";
            input.value = cb.dataset.checkbox;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    });
}

export function checkAll() {
    const checkAll = document.getElementById("check_all");
    if (!checkAll) return;

    checkAll.addEventListener("change", () => {
        const checkboxes = document.querySelectorAll(".checkbox-flip.checkbox_change");
        checkboxes.forEach(cb => {
            cb.checked = checkAll.checked;
        });
    });
}
