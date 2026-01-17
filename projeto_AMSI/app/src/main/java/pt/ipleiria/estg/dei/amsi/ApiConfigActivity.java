package pt.ipleiria.estg.dei.amsi;

import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import pt.ipleiria.estg.dei.amsi.api.ApiConfig;

public class ApiConfigActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_api_config);

        EditText edtApiUrl = findViewById(R.id.edtApiUrl);
        Button btnSaveApi = findViewById(R.id.btnSaveApi);

        // mostra URL atual
        edtApiUrl.setText(ApiConfig.getBaseUrl(this));

        btnSaveApi.setOnClickListener(v -> {
            String url = edtApiUrl.getText().toString().trim();

            if (!url.endsWith("/")) {
                url += "/";
            }

            ApiConfig.setBaseUrl(this, url);
            Toast.makeText(this, "Servidor configurado!", Toast.LENGTH_SHORT).show();
            finish();
        });
    }
}
