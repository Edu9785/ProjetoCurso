package pt.ipleiria.estg.dei.amsi.api.models;

public class Resposta {

    private int id;
    private String resposta;
    private boolean correta;
    private int idPergunta;

    // =========================
    // CONSTRUTORES
    // =========================

    public Resposta(int id, String resposta, boolean correta, int idPergunta) {
        this.id = id;
        this.resposta = resposta;
        this.correta = correta;
        this.idPergunta = idPergunta;
    }

    // Usado quando lês da BD offline (já sabes o idPergunta)
    public Resposta(int id, String resposta, boolean correta) {
        this.id = id;
        this.resposta = resposta;
        this.correta = correta;
    }

    // =========================
    // GETTERS & SETTERS
    // =========================

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getResposta() {
        return resposta;
    }

    public void setResposta(String resposta) {
        this.resposta = resposta;
    }

    public boolean isCorreta() {
        return correta;
    }

    public void setCorreta(boolean correta) {
        this.correta = correta;
    }

    public int getIdPergunta() {
        return idPergunta;
    }

    public void setIdPergunta(int idPergunta) {
        this.idPergunta = idPergunta;
    }
}
