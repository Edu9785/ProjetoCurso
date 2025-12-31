package pt.ipleiria.estg.dei.amsi;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.google.android.material.bottomnavigation.BottomNavigationView;

public class HomeFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_home, container, false);

        // Botão "Explorar jogos"
        Button btnExploreGames = view.findViewById(R.id.btnExploreGames);

        btnExploreGames.setOnClickListener(v -> {

            // Trocar para o fragment Jogos
            requireActivity()
                    .getSupportFragmentManager()
                    .beginTransaction()
                    .replace(R.id.homeFragmentContainer, new JogosFragment())
                    .addToBackStack(null)
                    .commit();

            // Atualizar o item selecionado no BottomNavigation
            BottomNavigationView bottomNav =
                    requireActivity().findViewById(R.id.bottomNavigation);
            bottomNav.setSelectedItemId(R.id.nav_games);
        });

        return view;
    }
}
