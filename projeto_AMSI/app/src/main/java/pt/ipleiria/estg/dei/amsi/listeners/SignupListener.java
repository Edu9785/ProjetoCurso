package pt.ipleiria.estg.dei.amsi.listeners;

public interface SignupListener {
    void onSignupSuccess();
    void onSignupError(String message);
}
