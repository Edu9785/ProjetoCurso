package pt.ipleiria.estg.dei.amsi.api.models;

public class LoginResponse {

    private boolean success;
    private String message;

    private int user_id;
    private int jogador_id;

    // 🔹 Getters
    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public int getUser_id() {
        return user_id;
    }

    public int getJogador_id() {
        return jogador_id;
    }
}
