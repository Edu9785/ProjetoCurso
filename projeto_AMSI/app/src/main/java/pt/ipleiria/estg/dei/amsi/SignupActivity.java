package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;
import pt.ipleiria.estg.dei.amsi.listeners.SignupListener;

public class SignupActivity extends AppCompatActivity implements SignupListener {

    private EditText edtUsername, edtPlayerName, edtAge, edtEmail, edtPassword;
    private SingletonAPI singleton;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);

        singleton = SingletonAPI.getInstance(this);
        singleton.setSignupListener(this);

        ImageButton btnBack = findViewById(R.id.btnBack);
        btnBack.setOnClickListener(v -> {
            startActivity(new Intent(this, WelcomeActivity.class));
            finish();
        });

        edtUsername = findViewById(R.id.edtUsername);
        edtPlayerName = findViewById(R.id.edtPlayerName);
        edtAge = findViewById(R.id.edtAge);
        edtEmail = findViewById(R.id.edtEmail);
        edtPassword = findViewById(R.id.edtPassword);
        Button btnSignup = findViewById(R.id.btnSignup);

        btnSignup.setOnClickListener(v -> {

            String username = edtUsername.getText().toString().trim();
            String nome = edtPlayerName.getText().toString().trim();
            String idade = edtAge.getText().toString().trim();
            String email = edtEmail.getText().toString().trim();
            String password = edtPassword.getText().toString().trim();

            if (username.isEmpty() || nome.isEmpty() || idade.isEmpty() || email.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Preenche todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            singleton.signupAPI(username, nome, idade, email, password, this);
        });
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        // Evita leaks: remove listener quando activity morre
        if (singleton != null) singleton.setSignupListener(null);
    }

    @Override
    public void onSignupSuccess() {
        Toast.makeText(this, "Conta criada com sucesso!", Toast.LENGTH_SHORT).show();
        startActivity(new Intent(this, MainActivity.class));
        finish();
    }

    @Override
    public void onSignupError(String message) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show();
    }
}
