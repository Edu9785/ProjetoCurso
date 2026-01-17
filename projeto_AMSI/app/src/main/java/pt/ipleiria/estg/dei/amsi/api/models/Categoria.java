package pt.ipleiria.estg.dei.amsi.api.models;

public class Categoria {

    private int id;
    private String categoria;

    // =========================
    // CONSTRUTORES
    // =========================
    public Categoria() {
    }

    public Categoria(int id, String categoria) {
        this.id = id;
        this.categoria = categoria;
    }

    // =========================
    // GETTERS
    // =========================
    public int getId() {
        return id;
    }

    public String getCategoria() {
        return categoria;
    }

    // =========================
    // SETTERS
    // =========================
    public void setId(int id) {
        this.id = id;
    }

    public void setCategoria(String categoria) {
        this.categoria = categoria;
    }
}
