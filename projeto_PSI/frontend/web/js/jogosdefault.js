// Adicionar nova categoria
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("categorias-wrapper");
    const addBtn = document.getElementById("add-categoria");

    // Supondo que categoriasData seja um array de objetos: [{id:1, nome:"Ação"}, ...]
    // Você pode passar do PHP para JS via JSON:
    // <script>const categoriasData = <?= json_encode($categorias) ?>;</script>

    addBtn.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("categoria-item", "mb-3", "d-flex", "gap-2");

        let select = document.createElement("select");
        select.name = "JogosDefaultSearch[categorias][]";
        select.classList.add("form-select");

        select.innerHTML = `<option value="">Escolha...</option>` +
            categoriasData.map(cat => `<option value="${cat.id}">${cat.nome}</option>`).join('');

        let btnRemove = document.createElement("button");
        btnRemove.type = "button";
        btnRemove.classList.add("btn", "btn-danger", "btn-sm", "remove-categoria");
        btnRemove.textContent = "Remover";

        div.appendChild(select);
        div.appendChild(btnRemove);
        wrapper.appendChild(div);
    });

    // Remover categoria selecionada
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-categoria")) {
            e.target.parentElement.remove();
        }
    });
});
