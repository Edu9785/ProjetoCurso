package pt.ipleiria.estg.dei.amsi;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.Spinner;

import androidx.annotation.NonNull;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;

import java.util.Arrays;
import java.util.List;

public class JogosFragment extends Fragment {

    private DrawerLayout drawerLayout;
    private LinearLayout containerCategorias;
    private Spinner spinnerDificuldade;

    // Exemplo de categorias (depois vens buscar à API)
    private final List<String> categorias = Arrays.asList(
            "Todas",
            "História",
            "Ciência",
            "Geografia",
            "Desporto",
            "Tecnologia"
    );

    // Exemplo de dificuldades
    private final List<String> dificuldades = Arrays.asList(
            "Todas",
            "Fácil",
            "Médio",
            "Difícil"
    );

    @Override
    public View onCreateView(
            @NonNull LayoutInflater inflater,
            ViewGroup container,
            Bundle savedInstanceState
    ) {

        View view = inflater.inflate(R.layout.fragment_jogos, container, false);

        drawerLayout = view.findViewById(R.id.drawerLayout);
        ImageButton btnOpenFilters = view.findViewById(R.id.btnOpenFilters);
        Button btnApplyFilters = view.findViewById(R.id.btnAplicarFiltros);
        Button btnAddCategoria = view.findViewById(R.id.btnAddCategoria);
        containerCategorias = view.findViewById(R.id.containerCategorias);
        spinnerDificuldade = view.findViewById(R.id.spinnerDificuldade);

        // ☰ Abrir sidebar
        btnOpenFilters.setOnClickListener(v ->
                drawerLayout.openDrawer(GravityCompat.END)
        );

        // ✔ Aplicar filtros (por agora só fecha)
        btnApplyFilters.setOnClickListener(v ->
                drawerLayout.closeDrawer(GravityCompat.END)
        );

        // ➕ Adicionar categoria
        btnAddCategoria.setOnClickListener(v ->
                adicionarSpinnerCategoria()
        );


        ArrayAdapter<String> adapterDificuldade = new ArrayAdapter<>(
                requireContext(),
                R.layout.spinner_item,
                dificuldades
        );
        adapterDificuldade.setDropDownViewResource(R.layout.spinner_dropdown_item);
        spinnerDificuldade.setAdapter(adapterDificuldade);


        if (containerCategorias.getChildCount() > 0) {
            View firstSpinnerView = containerCategorias.getChildAt(0);
            if (firstSpinnerView instanceof Spinner) {
                Spinner firstSpinner = (Spinner) firstSpinnerView;
                ArrayAdapter<String> adapterCategoria = new ArrayAdapter<>(
                        requireContext(),
                        R.layout.spinner_item,
                        categorias
                );
                adapterCategoria.setDropDownViewResource(R.layout.spinner_dropdown_item);
                firstSpinner.setAdapter(adapterCategoria);
            }
        }


        return view;
    }

    // 🔹 Método para criar um Spinner dinamicamente
    private void adicionarSpinnerCategoria() {
        Spinner spinner = new Spinner(requireContext());

        ArrayAdapter<String> adapter = new ArrayAdapter<>(
                requireContext(),
                R.layout.spinner_item,
                categorias
        );
        adapter.setDropDownViewResource(R.layout.spinner_dropdown_item);
        spinner.setAdapter(adapter);

        LinearLayout.LayoutParams params =
                new LinearLayout.LayoutParams(
                        ViewGroup.LayoutParams.MATCH_PARENT,
                        ViewGroup.LayoutParams.WRAP_CONTENT
                );

        params.topMargin = 16;
        spinner.setLayoutParams(params);

        containerCategorias.addView(spinner);
    }
}
