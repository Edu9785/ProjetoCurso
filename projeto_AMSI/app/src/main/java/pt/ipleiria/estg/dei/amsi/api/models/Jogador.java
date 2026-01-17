package pt.ipleiria.estg.dei.amsi.api.models;

public class Jogador {

    private int id;
    private String nome;
    private int idade;
    private int id_premium;

    // dados vindos do User
    private int id_user;
    private String email;

    // 🔹 Getters
    public int getId() {
        return id;
    }

    public String getNome() {
        return nome;
    }

    public int getIdade() {
        return idade;
    }

    public int getId_premium() {
        return id_premium;
    }

    public int getId_user() {
        return id_user;
    }

    public String getEmail() {
        return email;
    }
}
