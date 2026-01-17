package pt.ipleiria.estg.dei.amsi;

import android.os.Bundle;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

public class JogoResultadoActivity extends AppCompatActivity {

    private TextView txtPontos, txtAcertos;
    private LinearLayout containerPerguntas;
    private Button btnVoltar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_jogo_resultado);

        txtPontos = findViewById(R.id.txtPontos);
        txtAcertos = findViewById(R.id.txtAcertos);
        containerPerguntas = findViewById(R.id.containerPerguntas);
        btnVoltar = findViewById(R.id.btnVoltar);

        // Recebe dados da Activity do jogo
        int pontos = getIntent().getIntExtra("pontos", 0);
        ArrayList<String> perguntasAcertadas = getIntent().getStringArrayListExtra("perguntasAcertadas");

        txtPontos.setText(String.valueOf(pontos));
        txtAcertos.setText(String.valueOf(perguntasAcertadas != null ? perguntasAcertadas.size() : 0));

        // Adiciona TextViews dinamicamente com LayoutParams
        if (perguntasAcertadas != null && !perguntasAcertadas.isEmpty()) {
            for (String pergunta : perguntasAcertadas) {
                TextView tv = new TextView(this);
                tv.setText("• " + pergunta);
                tv.setTextSize(16f);
                tv.setPadding(8, 8, 8, 8);

                LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT,
                        LinearLayout.LayoutParams.WRAP_CONTENT
                );
                params.setMargins(0, 4, 0, 4);
                tv.setLayoutParams(params);

                containerPerguntas.addView(tv);
            }
        } else {
            TextView tv = new TextView(this);
            tv.setText("Não acertaste nenhuma pergunta.");
            tv.setTextSize(16f);
            tv.setTextColor(getResources().getColor(android.R.color.darker_gray));

            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT
            );
            params.setMargins(0, 4, 0, 4);
            tv.setLayoutParams(params);

            containerPerguntas.addView(tv);
        }

        btnVoltar.setOnClickListener(v -> finish());
    }
}
