package pt.ipleiria.estg.dei.amsi;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.amsi.api.ApiConfig;
import pt.ipleiria.estg.dei.amsi.api.models.Categoria;
import pt.ipleiria.estg.dei.amsi.api.models.Dificuldade;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.adapters.JogosAdapter;

import android.content.Intent;


public class JogosFragment extends Fragment {

    private DrawerLayout drawerLayout;
    private RecyclerView recyclerJogos;
    private LinearLayout containerCategorias;
    private Spinner spinnerDificuldade;

    private final List<JogoDefault> todosJogos = new ArrayList<>();

    @Override
    public View onCreateView(
            @NonNull LayoutInflater inflater,
            ViewGroup container,
            Bundle savedInstanceState
    ) {

        View view = inflater.inflate(R.layout.fragment_jogos, container, false);

        drawerLayout = view.findViewById(R.id.drawerLayout);
        recyclerJogos = view.findViewById(R.id.recyclerJogos);
        spinnerDificuldade = view.findViewById(R.id.spinnerDificuldade);
        containerCategorias = view.findViewById(R.id.containerCategorias);

        ImageButton btnOpenFilters = view.findViewById(R.id.btnOpenFilters);
        Button btnAplicarFiltros = view.findViewById(R.id.btnAplicarFiltros);
        Button btnAddCategoria = view.findViewById(R.id.btnAddCategoria);

        recyclerJogos.setLayoutManager(new GridLayoutManager(getContext(), 2));

        btnOpenFilters.setOnClickListener(v ->
                drawerLayout.openDrawer(GravityCompat.END)
        );

        btnAplicarFiltros.setOnClickListener(v -> {
            aplicarFiltros();
            drawerLayout.closeDrawer(GravityCompat.END);
        });

        btnAddCategoria.setOnClickListener(v -> adicionarCategoria());

        // garante 1 categoria inicial
        if (containerCategorias.getChildCount() == 0) {
            adicionarCategoria();
        }

        carregarJogos();

        return view;
    }

    // =========================
    // CARREGAR JOGOS
    // =========================
    private void carregarJogos() {

        String url = ApiConfig.BASE_URL + "jogodefault";

        JsonArrayRequest request = new JsonArrayRequest(
                Request.Method.GET,
                url,
                null,
                response -> {
                    List<JogoDefault> jogos =
                            new Gson().fromJson(
                                    response.toString(),
                                    new TypeToken<List<JogoDefault>>() {}.getType()
                            );

                    todosJogos.clear();
                    todosJogos.addAll(jogos);

                    mostrarJogos(jogos);
                },
                error -> Toast.makeText(getContext(),
                        "Erro ao carregar jogos",
                        Toast.LENGTH_SHORT).show()
        );

        Volley.newRequestQueue(requireContext()).add(request);
    }

    private void mostrarJogos(List<JogoDefault> jogos) {

        recyclerJogos.setAdapter(new JogosAdapter(jogos, new JogosAdapter.OnJogoClickListener() {

            @Override
            public void onDetalhes(JogoDefault jogo) {
                Bundle b = new Bundle();
                b.putInt("jogo_id", jogo.getId());

                JogoDetalhesFragment fragment = new JogoDetalhesFragment();
                fragment.setArguments(b);

                requireActivity().getSupportFragmentManager()
                        .beginTransaction()
                        .replace(R.id.homeFragmentContainer, fragment)
                        .addToBackStack(null)
                        .commit();
            }

            @Override
            public void onJogar(JogoDefault jogo) {
                Intent i = new Intent(getContext(), JogoJogarActivity.class);
                i.putExtra("jogo_id", jogo.getId());
                startActivity(i);
            }
        }));
    }


    // =========================
    // FILTROS
    // =========================
    private void aplicarFiltros() {

        List<JogoDefault> filtrados = new ArrayList<>(todosJogos);

        // dificuldade
        if (spinnerDificuldade.getSelectedItemPosition() > 0) {
            int difId = ((Dificuldade) spinnerDificuldade.getSelectedItem()).getId();
            filtrados.removeIf(j ->
                    j.getDificuldade() == null ||
                            j.getDificuldade().getId() != difId
            );
        }

        // categorias
        List<Integer> categoriasSelecionadas = new ArrayList<>();

        for (int i = 0; i < containerCategorias.getChildCount(); i++) {
            Spinner sp = containerCategorias.getChildAt(i)
                    .findViewById(R.id.spinnerCategoria);

            if (sp.getSelectedItemPosition() > 0) {
                categoriasSelecionadas.add(
                        ((Categoria) sp.getSelectedItem()).getId()
                );
            }
        }

        if (!categoriasSelecionadas.isEmpty()) {
            filtrados.removeIf(j -> !jogoTemCategorias(j, categoriasSelecionadas));
        }

        mostrarJogos(filtrados);
    }

    private boolean jogoTemCategorias(JogoDefault jogo, List<Integer> ids) {

        for (int id : ids) {
            boolean ok = false;
            for (Categoria c : jogo.getCategorias()) {
                if (c.getId() == id) {
                    ok = true;
                    break;
                }
            }
            if (!ok) return false;
        }
        return true;
    }

    // =========================
    // CATEGORIAS DINÂMICAS
    // =========================
    private void adicionarCategoria() {

        View item = LayoutInflater.from(getContext())
                .inflate(R.layout.item_categoria_spinner, containerCategorias, false);

        ImageButton btnRemove = item.findViewById(R.id.btnRemover);

        btnRemove.setOnClickListener(v -> {
            if (containerCategorias.getChildCount() > 1) {
                containerCategorias.removeView(item);
            }
            atualizarRemover();
        });

        containerCategorias.addView(item);
        atualizarRemover();
    }

    private void atualizarRemover() {

        int count = containerCategorias.getChildCount();

        for (int i = 0; i < count; i++) {
            ImageButton btn =
                    containerCategorias.getChildAt(i).findViewById(R.id.btnRemover);
            btn.setVisibility(count > 1 ? View.VISIBLE : View.GONE);
        }
    }
}
