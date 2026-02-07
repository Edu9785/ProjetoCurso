package pt.ipleiria.estg.dei.amsi.api.models;

import java.util.List;

public class JogoDefault {

    private int id;
    private String titulo;
    private String descricao;
    private String imagem;
    private int totalpontosjogo;

    // Relações vindas da API
    private Dificuldade dificuldade;
    private List<Categoria> categorias;

    // =========================
    // CONSTRUTORES
    // =========================
    public JogoDefault() {
    }

    public JogoDefault(int id, String titulo, String descricao, String imagem, int totalpontosjogo, Dificuldade dificuldade, List<Categoria> categorias) {
        this.id = id;
        this.titulo = titulo;
        this.descricao = descricao;
        this.imagem = imagem;
        this.totalpontosjogo = totalpontosjogo;
        this.dificuldade = dificuldade;
        this.categorias = categorias;
    }

    // =========================
    // GETTERS
    // =========================
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

    public int getTotalpontosjogo() {
        return totalpontosjogo;
    }

    public Dificuldade getDificuldade() {
        return dificuldade;
    }

    public List<Categoria> getCategorias() {
        return categorias;
    }

    // =========================
    // SETTERS
    // =========================
    public void setId(int id) {
        this.id = id;
    }

    public void setTitulo(String titulo) {
        this.titulo = titulo;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public void setImagem(String imagem) {
        this.imagem = imagem;
    }

    public void setTotalpontosjogo(int totalpontosjogo) {
        this.totalpontosjogo = totalpontosjogo;
    }

    public void setDificuldade(Dificuldade dificuldade) {
        this.dificuldade = dificuldade;
    }

    public void setCategorias(List<Categoria> categorias) {
        this.categorias = categorias;
    }
}
