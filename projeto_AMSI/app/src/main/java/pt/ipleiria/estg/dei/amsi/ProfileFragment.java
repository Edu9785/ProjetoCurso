package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

public class ProfileFragment extends Fragment {

    private EditText edtName, edtAge, edtEmail;
    private Button btnEditProfile, btnSaveProfile, btnCancelEdit, btnLogout;
    private View layoutEditActions;

    @Nullable
    @Override
    public View onCreateView(
            @NonNull LayoutInflater inflater,
            @Nullable ViewGroup container,
            @Nullable Bundle savedInstanceState
    ) {

        View view = inflater.inflate(R.layout.fragment_profile, container, false);

        // Campos
        edtName = view.findViewById(R.id.edtName);
        edtAge = view.findViewById(R.id.edtAge);
        edtEmail = view.findViewById(R.id.edtEmail);

        // Botões
        btnEditProfile = view.findViewById(R.id.btnEditProfile);
        btnSaveProfile = view.findViewById(R.id.btnSaveProfile);
        btnCancelEdit = view.findViewById(R.id.btnCancelEdit);
        btnLogout = view.findViewById(R.id.btnLogout);
        layoutEditActions = view.findViewById(R.id.layoutEditActions);

        // 🔒 Estado inicial: bloqueado
        setEditable(false);

        // ✏️ Editar perfil
        btnEditProfile.setOnClickListener(v -> {
            setEditable(true);
            btnEditProfile.setVisibility(View.GONE);
            layoutEditActions.setVisibility(View.VISIBLE);
        });

        // 💾 Guardar alterações
        btnSaveProfile.setOnClickListener(v -> {
            // Aqui depois ligas à API / BD
            setEditable(false);
            layoutEditActions.setVisibility(View.GONE);
            btnEditProfile.setVisibility(View.VISIBLE);
        });

        // ❌ Cancelar
        btnCancelEdit.setOnClickListener(v -> {
            // Aqui podes repor valores antigos se quiseres
            setEditable(false);
            layoutEditActions.setVisibility(View.GONE);
            btnEditProfile.setVisibility(View.VISIBLE);
        });

        // 🚪 Logout
        btnLogout.setOnClickListener(v -> {
            SharedPreferences prefs =
                    requireActivity().getSharedPreferences(
                            "user_session", getActivity().MODE_PRIVATE);

            prefs.edit().clear().apply();

            startActivity(new Intent(getActivity(), WelcomeActivity.class));
            requireActivity().finish();
        });

        return view;
    }

    // 🔒 Método central de controlo
    private void setEditable(boolean editable) {
        edtName.setEnabled(editable);
        edtAge.setEnabled(editable);
        edtEmail.setEnabled(editable);

        edtName.setFocusable(editable);
        edtAge.setFocusable(editable);
        edtEmail.setFocusable(editable);

        edtName.setFocusableInTouchMode(editable);
        edtAge.setFocusableInTouchMode(editable);
        edtEmail.setFocusableInTouchMode(editable);
    }
}
