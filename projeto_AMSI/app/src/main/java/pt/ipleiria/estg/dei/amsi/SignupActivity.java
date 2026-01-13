package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import pt.ipleiria.estg.dei.amsi.api.ApiConfig;

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
        EditText edtPlayerName = findViewById(R.id.edtPlayerName);
        EditText edtAge = findViewById(R.id.edtAge);
        EditText edtEmail = findViewById(R.id.edtEmail);
        EditText edtPassword = findViewById(R.id.edtPassword);
        Button btnSignup = findViewById(R.id.btnSignup);

        btnSignup.setOnClickListener(v -> {

            String username = edtUsername.getText().toString().trim();
            String nome = edtPlayerName.getText().toString().trim();
            String idade = edtAge.getText().toString().trim();
            String email = edtEmail.getText().toString().trim();
            String password = edtPassword.getText().toString().trim();

            if (username.isEmpty() || nome.isEmpty() || idade.isEmpty()
                    || email.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Preenche todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            signupApi(username, nome, idade, email, password);
        });
    }

    private void signupApi(String username, String nome, String idade, String email, String password) {

        String url = ApiConfig.BASE_URL + "auth/signup";

        StringRequest request = new StringRequest(
                Request.Method.POST,
                url,
                response -> {
                    try {
                        JSONObject json = new JSONObject(response);

                        if (!json.getBoolean("success")) {
                            Toast.makeText(
                                    this,
                                    json.optString("error", "Erro ao criar conta"),
                                    Toast.LENGTH_SHORT
                            ).show();
                            return;
                        }

                        int userId = json.getInt("user_id");
                        int jogadorId = json.getInt("jogador_id");
                        String token = json.getString("token");

                        // Guardar sessão
                        SharedPreferences prefs =
                                getSharedPreferences("user_session", MODE_PRIVATE);

                        prefs.edit()
                                .putBoolean("logged", true)
                                .putInt("user_id", userId)
                                .putInt("jogador_id", jogadorId)
                                .putString("token", token)
                                .apply();

                        startActivity(new Intent(this, MainActivity.class));
                        finish();

                    } catch (JSONException e) {
                        Toast.makeText(this, "Erro ao processar resposta", Toast.LENGTH_SHORT).show();
                    }
                },
                error -> Toast.makeText(
                        this,
                        "Erro de ligação ao servidor",
                        Toast.LENGTH_SHORT
                ).show()
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("nome", nome);
                params.put("idade", idade);
                params.put("email", email);
                params.put("password", password);
                return params;
            }
        };

        RequestQueue queue = Volley.newRequestQueue(this);
        queue.add(request);
    }
}
