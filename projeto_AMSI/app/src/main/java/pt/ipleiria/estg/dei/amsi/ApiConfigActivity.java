package pt.ipleiria.estg.dei.amsi;

import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.amsi.api.ApiConfig;

public class ApiConfigActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_api_config);

        ImageButton btnBack = findViewById(R.id.btnBack);
        EditText edtApiUrl = findViewById(R.id.edtApiUrl);
        Button btnSaveApi = findViewById(R.id.btnSaveApi);

        // mostra o IP atual (guardado)
        edtApiUrl.setText(ApiConfig.getBaseUrl(this)
                .replace("http://", "")
                .replace("/ProjetoCurso/projeto_PSI/backend/web/api/", ""));

        // botão voltar
        btnBack.setOnClickListener(v -> finish());

        // guardar IP
        btnSaveApi.setOnClickListener(v -> {
            String ip = edtApiUrl.getText().toString().trim();

            if (ip.isEmpty()) {
                Toast.makeText(this, "Introduz um IP válido", Toast.LENGTH_SHORT).show();
                return;
            }

            String fullUrl =
                    "http://" + ip + "/ProjetoCurso/projeto_PSI/backend/web/api/";

            ApiConfig.setBaseUrl(this, fullUrl);

            Toast.makeText(this, "Servidor configurado!", Toast.LENGTH_SHORT).show();
            finish();
        });
    }
}
