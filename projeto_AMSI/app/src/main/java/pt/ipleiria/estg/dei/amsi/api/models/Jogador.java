package pt.ipleiria.estg.dei.amsi.api.models;

public class Jogador {

    private int id;
    private String nome;
    private int idade;
    private int id_premium;

    // dados vindos do User
    private String username;
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

    public String getUsername() {
        return username;
    }

    public String getEmail() {
        return email;
    }
}
