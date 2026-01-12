package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
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

public class LoginActivity extends AppCompatActivity {

    private EditText edtUsername, edtPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        ImageButton btnBack = findViewById(R.id.btnBack);
        edtUsername = findViewById(R.id.edtUsername);
        edtPassword = findViewById(R.id.edtPassword);
        Button btnLogin = findViewById(R.id.btnLogin);

        // 🔙 Voltar
        btnBack.setOnClickListener(v -> {
            startActivity(new Intent(this, WelcomeActivity.class));
            finish();
        });

        // 🔐 Login real
        btnLogin.setOnClickListener(v -> {
            String username = edtUsername.getText().toString().trim();
            String password = edtPassword.getText().toString().trim();

            if (username.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Preenche todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            loginApi(username, password);
        });
    }

    // 🔗 LOGIN COM API
    private void loginApi(String username, String password) {

        String url = ApiConfig.BASE_URL + "auth/login";

        StringRequest request = new StringRequest(
                Request.Method.POST,
                url,
                response -> {
                    try {
                        Log.d("LOGIN_RESPONSE", response);

                        JSONObject json = new JSONObject(response);

                        if (!json.getBoolean("success")) {
                            Toast.makeText(
                                    this,
                                    json.optString("error", "Credenciais inválidas"),
                                    Toast.LENGTH_SHORT
                            ).show();
                            return;
                        }

                        int userId = json.getInt("user_id");
                        int jogadorId = json.getInt("jogador_id");
                        String token = json.getString("token");

                        // 💾 Guardar sessão REAL
                        SharedPreferences prefs =
                                getSharedPreferences("user_session", MODE_PRIVATE);

                        prefs.edit()
                                .putBoolean("logged", true)
                                .putInt("user_id", userId)
                                .putInt("jogador_id", jogadorId)
                                .putString("token", token)
                                .apply();

                        // 👉 Ir para a app
                        startActivity(new Intent(this, MainActivity.class));
                        finish();

                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(
                                this,
                                "Erro ao processar resposta da API",
                                Toast.LENGTH_SHORT
                        ).show();
                    }
                },
                error -> {
                    error.printStackTrace();
                    Toast.makeText(
                            this,
                            "Erro de ligação ao servidor",
                            Toast.LENGTH_SHORT
                    ).show();
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);
                return params;
            }
        };

        RequestQueue queue = Volley.newRequestQueue(this);
        queue.add(request);
    }
}
