// Adicionar nova categoria
document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("categorias-wrapper");
    const addBtn = document.getElementById("add-categoria");

    addBtn.addEventListener("click", function () {
        const div = document.createElement("div");
        div.classList.add("categoria-item", "mb-3", "d-flex", "gap-2");

        // Criar nova dropdown
        let select = document.createElement("select");
        select.name = "categorias[]";
        select.classList.add("form-select");

        // Criar opções a partir do JSON vindo do PHP
        select.innerHTML = `<option value="">Escolha...</option>` +
            categoriasData
                .map(cat => `<option value="${cat.id}">${cat.nome}</option>`)
                .join('');

        // Botão remover
        let btnRemove = document.createElement("button");
        btnRemove.type = "button";
        btnRemove.classList.add("btn", "btn-danger", "btn-sm", "remove-categoria");
        btnRemove.textContent = "Remover";

        // Inserir no wrapper
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
