package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import android.widget.ImageButton;

import androidx.appcompat.app.AppCompatActivity;

public class SignupActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);

        ImageButton btnBack = findViewById(R.id.btnBack);

        btnBack.setOnClickListener(v -> {
            startActivity(new Intent(this, WelcomeActivity.class));
            finish();
        });

        EditText edtUsername = findViewById(R.id.edtUsername);
        EditText edtEmail = findViewById(R.id.edtEmail);
        EditText edtPassword = findViewById(R.id.edtPassword);
        Button btnSignup = findViewById(R.id.btnSignup);

        btnSignup.setOnClickListener(v -> {

            String username = edtUsername.getText().toString().trim();
            String email = edtEmail.getText().toString().trim();
            String password = edtPassword.getText().toString().trim();

            if (username.isEmpty() || email.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Preenche todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            // SIGNUP FAKE (por agora)
            SharedPreferences prefs = getSharedPreferences("user_session", MODE_PRIVATE);
            prefs.edit()
                    .putBoolean("logged", true)
                    .putString("username", username)
                    .putString("email", email)
                    .apply();

            startActivity(new Intent(this, MainActivity.class));
            finish();
        });
    }
}
