package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
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

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.amsi.adapters.JogosAdapter;
import pt.ipleiria.estg.dei.amsi.api.DBHelper;
import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;
import pt.ipleiria.estg.dei.amsi.api.models.Categoria;
import pt.ipleiria.estg.dei.amsi.api.models.Dificuldade;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.listeners.CategoriasListener;
import pt.ipleiria.estg.dei.amsi.listeners.DificuldadesListener;
import pt.ipleiria.estg.dei.amsi.listeners.JogosListener;

public class JogosFragment extends Fragment
        implements JogosListener, CategoriasListener, DificuldadesListener {

    // UI
    private DrawerLayout drawerLayout;
    private RecyclerView recyclerJogos;
    private EditText edtSearch;
    private ImageButton btnOpenFilters;

    private Spinner spinnerDificuldade;
    private LinearLayout containerCategorias;
    private Button btnAddCategoria, btnAplicarFiltros;

    // Dados
    private ArrayList<JogoDefault> jogosBase = new ArrayList<>();
    private final ArrayList<Integer> selectedCategoriaIds = new ArrayList<>();

    private Integer selectedDificuldadeId = null;
    private String currentSearch = "";

    private final ArrayList<DificuldadeItem> dificuldades = new ArrayList<>();
    private final ArrayList<CategoriaItem> categorias = new ArrayList<>();

    @Override
    public View onCreateView(
            @NonNull LayoutInflater inflater,
            ViewGroup container,
            Bundle savedInstanceState
    ) {
        View view = inflater.inflate(R.layout.fragment_jogos, container, false);

        // Bind UI
        drawerLayout = view.findViewById(R.id.drawerLayout);
        recyclerJogos = view.findViewById(R.id.recyclerJogos);
        edtSearch = view.findViewById(R.id.edtSearch);
        btnOpenFilters = view.findViewById(R.id.btnOpenFilters);

        spinnerDificuldade = view.findViewById(R.id.spinnerDificuldade);
        containerCategorias = view.findViewById(R.id.containerCategorias);
        btnAddCategoria = view.findViewById(R.id.btnAddCategoria);
        btnAplicarFiltros = view.findViewById(R.id.btnAplicarFiltros);

        recyclerJogos.setLayoutManager(new GridLayoutManager(getContext(), 2));

        SingletonAPI api = SingletonAPI.getInstance(requireContext());
        api.setJogosListener(this);
        api.setCategoriasListener(this);
        api.setDificuldadesListener(this);

        // Carregar dados iniciais
        api.getCategoriasAPI(requireContext());
        api.getDificuldadesAPI(requireContext());
        api.getJogosAPI(requireContext(), null, null);

        // Abrir filtros
        btnOpenFilters.setOnClickListener(v ->
                drawerLayout.openDrawer(GravityCompat.END)
        );

        // Adicionar categoria
        btnAddCategoria.setOnClickListener(v -> addCategoriaRow());

        // Aplicar filtros
        btnAplicarFiltros.setOnClickListener(v -> {
            selectedDificuldadeId = getSelectedDificuldadeId();
            readSelectedCategoriasFromUI();

            api.getJogosAPI(
                    requireContext(),
                    selectedDificuldadeId,
                    currentSearch
            );

            drawerLayout.closeDrawer(GravityCompat.END);
        });

        // Pesquisa por nome
        edtSearch.addTextChangedListener(new TextWatcher() {
            @Override public void beforeTextChanged(CharSequence s,int a,int b,int c){}
            @Override public void onTextChanged(CharSequence s,int a,int b,int c){}

            @Override
            public void afterTextChanged(Editable s) {
                currentSearch = s.toString().trim();

                api.getJogosAPI(
                        requireContext(),
                        selectedDificuldadeId,
                        currentSearch
                );
            }
        });

        return view;
    }

    // =========================
    // CALLBACK JOGOS
    // =========================
    @Override
    public void onRefreshListaJogos(ArrayList<JogoDefault> jogos) {

        jogosBase = jogos;

        ArrayList<JogoDefault> resultado;

        if (selectedCategoriaIds.isEmpty() || allCategoriasSelecionadasSaoZero()) {
            resultado = jogosBase;
        } else {
            resultado = applyCategoriasFilterLocal(jogosBase);
        }

        recyclerJogos.setAdapter(new JogosAdapter(
                resultado,
                new JogosAdapter.OnJogoClickListener() {
                    @Override
                    public void onDetalhes(JogoDefault jogo) {
                        JogoDetalhesFragment fragment =
                                JogoDetalhesFragment.newInstance(jogo.getId());

                        requireActivity().getSupportFragmentManager()
                                .beginTransaction()
                                .replace(R.id.homeFragmentContainer, fragment)
                                .addToBackStack(null)
                                .commit();
                    }

                    @Override
                    public void onJogar(JogoDefault jogo) {
                        Intent i = new Intent(
                                getContext(),
                                JogoJogarActivity.class);
                        i.putExtra("id_jogo", jogo.getId());
                        startActivity(i);
                    }
                }
        ));
    }

    // =========================
    // CALLBACKS SPINNERS
    // =========================
    @Override
    public void onRefreshCategorias(ArrayList<Categoria> lista) {
        categorias.clear();
        categorias.add(new CategoriaItem(0, "Todas"));

        for (Categoria c : lista) {
            categorias.add(new CategoriaItem(
                    c.getId(),
                    c.getCategoria()
            ));
        }

        ensureAtLeastOneCategoriaRow();
        updateCategoriaSpinners();
    }

    @Override
    public void onRefreshDificuldades(ArrayList<Dificuldade> lista) {
        dificuldades.clear();
        dificuldades.add(new DificuldadeItem(0, "Todas"));

        for (Dificuldade d : lista) {
            dificuldades.add(new DificuldadeItem(
                    d.getId(),
                    d.getDificuldade()
            ));
        }

        ArrayAdapter<DificuldadeItem> adapter =
                new ArrayAdapter<>(
                        requireContext(),
                        R.layout.spinner_item,
                        dificuldades
                );

        adapter.setDropDownViewResource(R.layout.spinner_dropdown_item);
        spinnerDificuldade.setAdapter(adapter);
        spinnerDificuldade.setSelection(0);
    }

    // =========================
    // FILTROS
    // =========================
    private Integer getSelectedDificuldadeId() {
        Object sel = spinnerDificuldade.getSelectedItem();
        if (sel instanceof DificuldadeItem) {
            int id = ((DificuldadeItem) sel).id;
            return id <= 0 ? null : id;
        }
        return null;
    }

    private void readSelectedCategoriasFromUI() {
        selectedCategoriaIds.clear();

        for (int i = 0; i < containerCategorias.getChildCount(); i++) {
            Spinner sp = containerCategorias
                    .getChildAt(i)
                    .findViewById(R.id.spinnerCategoria);

            Object sel = sp.getSelectedItem();
            if (sel instanceof CategoriaItem) {
                selectedCategoriaIds.add(
                        ((CategoriaItem) sel).id
                );
            }
        }
    }

    private boolean allCategoriasSelecionadasSaoZero() {
        for (int id : selectedCategoriaIds) {
            if (id > 0) return false;
        }
        return true;
    }

    private ArrayList<JogoDefault> applyCategoriasFilterLocal(
            ArrayList<JogoDefault> base) {

        ArrayList<JogoDefault> out = new ArrayList<>();

        for (JogoDefault jogo : base) {
            List<Categoria> cats = jogo.getCategorias();
            if (cats == null) continue;

            boolean ok = true;

            for (int wanted : selectedCategoriaIds) {
                if (wanted <= 0) continue;

                boolean found = false;
                for (Categoria c : cats) {
                    if (c.getId() == wanted) {
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    ok = false;
                    break;
                }
            }

            if (ok) out.add(jogo);
        }

        if (out.isEmpty()) {
            Toast.makeText(
                    requireContext(),
                    "Nenhum jogo encontrado",
                    Toast.LENGTH_SHORT
            ).show();
        }

        return out;
    }

    // =========================
    // UI CATEGORIAS
    // =========================
    private void addCategoriaRow() {
        View row = LayoutInflater.from(requireContext())
                .inflate(R.layout.row_categoria_spinner,
                        containerCategorias, false);

        Spinner sp = row.findViewById(R.id.spinnerCategoria);
        ImageView btnRemove = row.findViewById(R.id.btnRemover);

        ArrayAdapter<CategoriaItem> adapter =
                new ArrayAdapter<>(
                        requireContext(),
                        R.layout.spinner_item,
                        categorias
                );

        adapter.setDropDownViewResource(R.layout.spinner_dropdown_item);
        sp.setAdapter(adapter);
        sp.setSelection(0);

        btnRemove.setOnClickListener(v -> {
            if (containerCategorias.getChildCount() > 1) {
                containerCategorias.removeView(row);
            }
        });

        containerCategorias.addView(row);
    }

    private void ensureAtLeastOneCategoriaRow() {
        if (containerCategorias.getChildCount() == 0) {
            addCategoriaRow();
        }
    }

    private void updateCategoriaSpinners() {
        for (int i = 0; i < containerCategorias.getChildCount(); i++) {
            Spinner sp = containerCategorias
                    .getChildAt(i)
                    .findViewById(R.id.spinnerCategoria);

            ArrayAdapter<CategoriaItem> adapter =
                    new ArrayAdapter<>(
                            requireContext(),
                            R.layout.spinner_item,
                            categorias
                    );

            adapter.setDropDownViewResource(
                    R.layout.spinner_dropdown_item);

            sp.setAdapter(adapter);
        }
    }

    // =========================
    // AUX CLASSES
    // =========================
    private static class DificuldadeItem {
        int id; String nome;
        DificuldadeItem(int i,String n){id=i;nome=n;}
        @NonNull public String toString(){return nome;}
    }

    private static class CategoriaItem {
        int id; String nome;
        CategoriaItem(int i,String n){id=i;nome=n;}
        @NonNull public String toString(){return nome;}
    }
}
