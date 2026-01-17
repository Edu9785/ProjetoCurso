package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;
import pt.ipleiria.estg.dei.amsi.listeners.LoginListener;

public class LoginActivity extends AppCompatActivity implements LoginListener {

    private EditText edtUsername, edtPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        ImageButton btnBack = findViewById(R.id.btnBack);
        edtUsername = findViewById(R.id.edtUsername);
        edtPassword = findViewById(R.id.edtPassword);
        Button btnLogin = findViewById(R.id.btnLogin);

        btnBack.setOnClickListener(v -> {
            startActivity(new Intent(this, WelcomeActivity.class));
            finish();
        });

        btnLogin.setOnClickListener(v -> {
            String username = edtUsername.getText().toString().trim();
            String password = edtPassword.getText().toString().trim();

            if (username.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Preenche todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            SingletonAPI.getInstance(getApplicationContext()).setLoginListener(this);
            SingletonAPI.getInstance(getApplicationContext()).loginAPI(username, password, this);
        });
    }

    @Override
    public void onLoginSuccess() {
        // ✅ Login ok -> ir para a app
        startActivity(new Intent(this, MainActivity.class));
        finish();
    }

    @Override
    public void onLoginError() {
        Toast.makeText(this, "Credenciais inválidas", Toast.LENGTH_SHORT).show();
    }
}
