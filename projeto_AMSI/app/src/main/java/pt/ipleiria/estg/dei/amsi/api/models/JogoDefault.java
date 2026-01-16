package pt.ipleiria.estg.dei.amsi.api.models;

import java.util.List;

public class JogoDefault {

    private int id;
    private String titulo;
    private String descricao;
    private String imagem;

    // Relações vindas da API
    private Dificuldade dificuldade;
    private List<Categoria> categorias;

    // 🔹 Getters (obrigatórios para Gson)
    public int getId() {
        return id;
    }

    public String getTitulo() {
        return titulo;
    }

    public String getDescricao() {
        return descricao;
    }

    public String getImagem() {
        return imagem;
    }

    public Dificuldade getDificuldade() {
        return dificuldade;
    }

    public List<Categoria> getCategorias() {
        return categorias;
    }
}
