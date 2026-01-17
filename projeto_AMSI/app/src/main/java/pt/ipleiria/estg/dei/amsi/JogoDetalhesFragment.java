package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.bumptech.glide.Glide;

import org.json.JSONArray;
import org.json.JSONObject;

import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;

public class JogoDetalhesFragment extends Fragment {

    private static final String ARG_JOGO_ID = "jogo_id";
    private int jogoId;

    private ImageView imgGame;
    private TextView txtGameTitle;
    private TextView txtCategory;
    private TextView txtDifficulty;
    private TextView txtTotalPontos;
    private TextView txtDescription;
    private Button btnPlay;

    public static JogoDetalhesFragment newInstance(int jogoId) {
        JogoDetalhesFragment fragment = new JogoDetalhesFragment();
        Bundle args = new Bundle();
        args.putInt(ARG_JOGO_ID, jogoId);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            jogoId = getArguments().getInt(ARG_JOGO_ID);
        }
    }

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_jogo_detalhes, container, false);

        imgGame = view.findViewById(R.id.imgGame);
        txtGameTitle = view.findViewById(R.id.txtGameTitle);
        txtCategory = view.findViewById(R.id.txtCategory);
        txtDifficulty = view.findViewById(R.id.txtDifficulty);
        txtDescription = view.findViewById(R.id.txtDescription);
        txtTotalPontos = view.findViewById(R.id.txtTotalPontos);
        btnPlay = view.findViewById(R.id.btnPlay);

        carregarJogoDetalhes();

        return view;
    }

    private void carregarJogoDetalhes() {
        SingletonAPI.getInstance(requireContext())
                .getJogoDetalhesAPI(jogoId, requireContext(), response -> {

                    if (response == null) {
                        Toast.makeText(requireContext(), "Jogo não encontrado", Toast.LENGTH_LONG).show();
                        return;
                    }

                    // 🔹 TÍTULO E DESCRIÇÃO
                    txtGameTitle.setText(response.optString("titulo", "-"));
                    txtDescription.setText(response.optString("descricao", "-"));

                    // 🔹 DIFICULDADE (OBJETO)
                    JSONObject dificuldadeObj = response.optJSONObject("dificuldade");
                    if (dificuldadeObj != null) {
                        txtDifficulty.setText("Dificuldade: " + dificuldadeObj.optString("nome", "-"));
                    } else {
                        txtDifficulty.setText("Dificuldade: -");
                    }

                    // 🔹 CATEGORIAS (ARRAY)
                    JSONArray categoriasArr = response.optJSONArray("categorias");
                    if (categoriasArr != null && categoriasArr.length() > 0) {
                        StringBuilder categoriasText = new StringBuilder();
                        for (int i = 0; i < categoriasArr.length(); i++) {
                            JSONObject cat = categoriasArr.optJSONObject(i);
                            if (cat != null) {
                                if (categoriasText.length() > 0) categoriasText.append(", ");
                                categoriasText.append(cat.optString("nome", "-"));
                            }
                        }
                        txtCategory.setText("Categorias: " + categoriasText.toString());
                    } else {
                        txtCategory.setText("-");
                    }

                    int totalPontos = response.optInt("totalpontosjogo", 0);
                    txtTotalPontos.setText("Total de Pontos: " + totalPontos);

                    // 🔹 IMAGEM
                    String imagem = response.optString("imagem", "");
                    if (!imagem.isEmpty()) {
                        String url =
                                "http://10.0.2.2/ProjetoCurso/projeto_PSI/frontend/web/uploads/" + imagem;

                        Glide.with(requireContext())
                                .load(url)
                                .placeholder(R.drawable.verde)
                                .error(R.drawable.verde)
                                .into(imgGame);
                    } else {
                        imgGame.setImageResource(R.drawable.verde);
                    }

                    // 🔹 BOTÃO JOGAR → abre JogoJogarActivity
                    btnPlay.setOnClickListener(v -> {
                        Intent intent = new Intent(requireContext(), JogoJogarActivity.class);
                        intent.putExtra("id_jogo", jogoId);
                        startActivity(intent);
                    });
                });
    }
}
