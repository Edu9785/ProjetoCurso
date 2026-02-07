package pt.ipleiria.estg.dei.amsi.api.models;

public class Dificuldade {

    private int id;
    private String dificuldade;

    // =========================
    // GETTERS
    // =========================
    public int getId() {
        return id;
    }

    public String getDificuldade() {
        return dificuldade;
    }

    // =========================
    // SETTERS
    // =========================
    public void setId(int id) {
        this.id = id;
    }

    public void setDificuldade(String dificuldade) {
        this.dificuldade = dificuldade;
    }
}
