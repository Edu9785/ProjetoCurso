package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

public class ProfileFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.fragment_profile, container, false);

        Button btnLogout = view.findViewById(R.id.btnLogout);

        btnLogout.setOnClickListener(v -> {

            // Limpar sessão
            SharedPreferences prefs =
                    requireActivity().getSharedPreferences("user_session",
                            getActivity().MODE_PRIVATE);

            prefs.edit().clear().apply();

            // Ir para Login
            Intent intent = new Intent(getActivity(), WelcomeActivity.class);
            startActivity(intent);

            // Fechar a MainActivity
            requireActivity().finish();
        });

        return view;
    }
}
