package pt.ipleiria.estg.dei.amsi.api.models;

import java.util.ArrayList;

public class Pergunta {

    private int id;
    private String pergunta;
    private int valor;

    // Relação hasMany (respostas)
    private ArrayList<Resposta> respostas;

    // =========================
    // CONSTRUTORES
    // =========================

    public Pergunta(int id, String pergunta, int valor) {
        this.id = id;
        this.pergunta = pergunta;
        this.valor = valor;
        this.respostas = new ArrayList<>();
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

    public String getPergunta() {
        return pergunta;
    }

    public void setPergunta(String pergunta) {
        this.pergunta = pergunta;
    }

    public int getValor() {
        return valor;
    }

    public void setValor(int valor) {
        this.valor = valor;
    }

    public ArrayList<Resposta> getRespostas() {
        return respostas;
    }

    public void setRespostas(ArrayList<Resposta> respostas) {
        this.respostas = respostas;
    }

    // =========================
    // HELPERS
    // =========================

    public void addResposta(Resposta resposta) {
        this.respostas.add(resposta);
    }
}
