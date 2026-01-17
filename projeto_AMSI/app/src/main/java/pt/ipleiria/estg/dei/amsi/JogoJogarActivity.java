package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;

public class JogoJogarActivity extends AppCompatActivity {

    private TextView txtQuestionCounter, txtQuestion;
    private LinearLayout answersContainer;

    private ArrayList<JSONObject> perguntas = new ArrayList<>();
    private int currentIndex = 0;
    private int pontos = 0;
    private ArrayList<Integer> acertos = new ArrayList<>();
    private int jogoId;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_jogo_jogar);

        txtQuestionCounter = findViewById(R.id.txtQuestionCounter);
        txtQuestion = findViewById(R.id.txtQuestion);
        answersContainer = findViewById(R.id.answersContainer);

        // Recebe o jogoId via Intent
        jogoId = getIntent().getIntExtra("id_jogo", 0);
        if (jogoId == 0) {
            Toast.makeText(this, "ID do jogo inválido", Toast.LENGTH_SHORT).show();
            finish();
            return;
        }

        loadPerguntas();
    }

    private void loadPerguntas() {
        SingletonAPI.getInstance(this).getPerguntasJogoAPI(jogoId, this, response -> {
            try {
                JSONArray arrPerguntas = response.getJSONArray("perguntas");
                for (int i = 0; i < arrPerguntas.length(); i++) {
                    perguntas.add(arrPerguntas.getJSONObject(i));
                }

                if (perguntas.isEmpty()) {
                    Toast.makeText(this, "Este jogo não tem perguntas.", Toast.LENGTH_LONG).show();
                    finish();
                    return;
                }

                showQuestion();

            } catch (Exception e) {
                e.printStackTrace();
                Toast.makeText(this, "Erro ao carregar perguntas", Toast.LENGTH_LONG).show();
            }
        });
    }

    private void showQuestion() {
        if (currentIndex >= perguntas.size()) {
            goToResultado();
            return;
        }

        JSONObject pergunta = perguntas.get(currentIndex);
        txtQuestion.setText(pergunta.optString("pergunta"));
        txtQuestionCounter.setText("Pergunta " + (currentIndex + 1) + "/" + perguntas.size());

        answersContainer.removeAllViews();

        JSONArray respostas = pergunta.optJSONArray("respostas");
        if (respostas == null) return;

        for (int i = 0; i < respostas.length(); i++) {
            JSONObject resp = respostas.optJSONObject(i);
            Button btn = new Button(this);
            btn.setText(resp.optString("resposta"));
            btn.setAllCaps(false);
            btn.setTag(resp); // guarda JSONObject da resposta
            btn.setOnClickListener(v -> checkAnswerAndNext((JSONObject) v.getTag()));
            answersContainer.addView(btn);
        }
    }

    private void checkAnswerAndNext(JSONObject resposta) {
        boolean correta = resposta.optBoolean("correta", false);
        int valor = 0;

        try {
            valor = perguntas.get(currentIndex).optInt("valor", 0);
        } catch (Exception e) {
            e.printStackTrace();
        }

        if (correta) {
            pontos += valor;
            acertos.add(perguntas.get(currentIndex).optInt("id"));
        }

        currentIndex++;
        showQuestion();
    }

    private void goToResultado() {
        ArrayList<String> perguntasAcertadasText = new ArrayList<>();
        for (int idPergunta : acertos) {
            try {
                JSONObject p = perguntas.get(currentIndex-1); // ou use mapa de id -> pergunta
                perguntasAcertadasText.add(p.getString("pergunta"));
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        Intent intent = new Intent(this, JogoResultadoActivity.class);
        intent.putExtra("pontos", pontos);
        intent.putStringArrayListExtra("perguntasAcertadas", perguntasAcertadasText);
        startActivity(intent);
        finish();
    }
}
