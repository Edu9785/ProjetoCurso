document.addEventListener("DOMContentLoaded", function () {
    const wrapper = document.getElementById("categorias-wrapper");
    const addBtn = document.getElementById("add-categoria");
    const searchInput = document.getElementById("search-jogos");
    const jogosGrid = document.getElementById("jogos-grid");

    // ===========================
    // 🔹 Adicionar nova categoria
    // ===========================
    if (addBtn && wrapper) {
        addBtn.addEventListener("click", function () {
            const div = document.createElement("div");
            div.classList.add("categoria-item", "mb-3", "d-flex", "gap-2");

            let select = document.createElement("select");
            select.name = "JogosDefaultSearch[categorias][]";
            select.classList.add("form-select");

            if (typeof categoriasData !== "undefined" && Array.isArray(categoriasData)) {
                select.innerHTML = "<option value=''>Escolha...</option>" +
                    categoriasData.map(cat => `<option value="${cat.id}">${cat.nome}</option>`).join('');
            } else {
                select.innerHTML = "<option value=''>Escolha...</option>";
            }

            let btnRemove = document.createElement("button");
            btnRemove.type = "button";
            btnRemove.classList.add("btn", "btn-danger", "btn-sm", "remove-categoria");
            btnRemove.textContent = "Remover";

            div.appendChild(select);
            div.appendChild(btnRemove);
            wrapper.appendChild(div);
        });

        // Remover categoria
        document.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-categoria")) {
                e.target.parentElement.remove();
            }
        });
    }

    // ===========================
    // 🔹 Pesquisa em tempo real
    // ===========================
    if (searchInput && jogosGrid && Array.isArray(window.jogosData)) {
        const renderJogoCard = (jogo) => {
            return `
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 border">
                    <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center">
                        ${jogo.imagem ? `<img src="${jogo.imagem}" alt="${jogo.titulo}" class="img-fluid object-fit-cover w-100 h-100">` : `<span class="text-muted">Sem imagem</span>`}
                    </div>
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">${jogo.titulo}</h6>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/pergunta/view?id_jogo=${jogo.id}" class="btn btn-primary btn-sm">Iniciar</a>
                            <a href="/jogosdefault/view?id=${jogo.id}" class="btn btn-outline-secondary btn-sm">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>`;
        };

        const filterAndRenderJogos = () => {
            const query = searchInput.value.trim().toLowerCase();

            const filtered = window.jogosData.filter(jogo =>
                jogo.titulo.toLowerCase().includes(query)
            );

            if (filtered.length > 0) {
                jogosGrid.innerHTML = filtered.map(renderJogoCard).join('');
            } else {
                jogosGrid.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-warning">Nenhum jogo encontrado com o filtro aplicado.</div>
                    </div>`;
            }
        };

        searchInput.addEventListener("input", filterAndRenderJogos);
    }
});
