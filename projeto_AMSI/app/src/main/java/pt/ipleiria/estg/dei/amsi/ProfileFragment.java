package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;

import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;
import pt.ipleiria.estg.dei.amsi.api.models.Jogador;
import pt.ipleiria.estg.dei.amsi.listeners.EditProfileListener;
import pt.ipleiria.estg.dei.amsi.listeners.ProfileListener;

public class ProfileFragment extends Fragment implements ProfileListener, EditProfileListener {

    private EditText edtUsername, edtName, edtAge, edtEmail;
    private Button btnEditProfile, btnSaveProfile, btnCancelEdit, btnLogout, btnDeleteAccount;
    private View layoutEditActions;

    private String originalUsername, originalNome, originalEmail;
    private int originalIdade;

    @Nullable
    @Override
    public View onCreateView(
            @NonNull LayoutInflater inflater,
            @Nullable ViewGroup container,
            @Nullable Bundle savedInstanceState
    ) {

        View view = inflater.inflate(R.layout.fragment_profile, container, false);

        edtUsername = view.findViewById(R.id.edtUsername);
        edtName = view.findViewById(R.id.edtName);
        edtAge = view.findViewById(R.id.edtAge);
        edtEmail = view.findViewById(R.id.edtEmail);

        btnEditProfile = view.findViewById(R.id.btnEditProfile);
        btnSaveProfile = view.findViewById(R.id.btnSaveProfile);
        btnCancelEdit = view.findViewById(R.id.btnCancelEdit);
        btnLogout = view.findViewById(R.id.btnLogout);
        btnDeleteAccount = view.findViewById(R.id.btnDeleteAccount);
        layoutEditActions = view.findViewById(R.id.layoutEditActions);

        setEditable(false);

        SingletonAPI api = SingletonAPI.getInstance(requireContext());
        api.setProfileListener(this);
        api.setEditProfileListener(this);

        api.getProfileAPI(requireContext());

        btnEditProfile.setOnClickListener(v -> {
            setEditable(true);
            btnEditProfile.setVisibility(View.GONE);
            layoutEditActions.setVisibility(View.VISIBLE);
        });

        btnSaveProfile.setOnClickListener(v -> saveProfile());

        btnCancelEdit.setOnClickListener(v -> {
            restoreOriginalValues();
            setEditable(false);
            layoutEditActions.setVisibility(View.GONE);
            btnEditProfile.setVisibility(View.VISIBLE);
        });

        btnLogout.setOnClickListener(v -> {
            SingletonAPI.getInstance(requireContext()).clearSession(requireContext());
            startActivity(new Intent(getActivity(), WelcomeActivity.class));
            requireActivity().finish();
        });

        btnDeleteAccount.setOnClickListener(v -> confirmDeleteAccount());

        return view;
    }

    @Override
    public void onLoadProfile(Jogador jogador) {
        originalUsername = jogador.getUsername();
        originalNome = jogador.getNome();
        originalIdade = jogador.getIdade();
        originalEmail = jogador.getEmail();

        edtUsername.setText(originalUsername);
        edtName.setText(originalNome);
        edtAge.setText(String.valueOf(originalIdade));
        edtEmail.setText(originalEmail);
    }

    private void saveProfile() {
        String username = edtUsername.getText().toString().trim();
        String nome = edtName.getText().toString().trim();
        String idadeStr = edtAge.getText().toString().trim();
        String email = edtEmail.getText().toString().trim();

        if (username.isEmpty() || nome.isEmpty() || idadeStr.isEmpty() || email.isEmpty()) {
            Toast.makeText(getContext(), "Preenche todos os campos", Toast.LENGTH_SHORT).show();
            return;
        }

        if (!Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            Toast.makeText(getContext(), "Email inválido", Toast.LENGTH_SHORT).show();
            return;
        }

        SingletonAPI.getInstance(requireContext()).editProfileAPI(
                username,
                email,
                nome,
                idadeStr,
                requireContext()
        );
    }

    @Override
    public void editProfileSuccess() {
        Toast.makeText(getContext(), "Perfil atualizado com sucesso", Toast.LENGTH_SHORT).show();
        setEditable(false);
        layoutEditActions.setVisibility(View.GONE);
        btnEditProfile.setVisibility(View.VISIBLE);

        SingletonAPI.getInstance(requireContext()).getProfileAPI(requireContext());
    }

    private void confirmDeleteAccount() {
        new AlertDialog.Builder(requireContext())
                .setTitle("Eliminar conta")
                .setMessage("Tens a certeza que queres eliminar a tua conta? Esta ação é irreversível.")
                .setPositiveButton("Eliminar", (dialog, which) ->
                        Toast.makeText(getContext(), "Ainda falta ligar ao endpoint DELETE", Toast.LENGTH_SHORT).show()
                )
                .setNegativeButton("Cancelar", null)
                .show();
    }

    private void restoreOriginalValues() {
        edtUsername.setText(originalUsername);
        edtName.setText(originalNome);
        edtAge.setText(String.valueOf(originalIdade));
        edtEmail.setText(originalEmail);
    }

    private void setEditable(boolean editable) {
        edtUsername.setEnabled(editable);
        edtName.setEnabled(editable);
        edtAge.setEnabled(editable);
        edtEmail.setEnabled(editable);
    }
}
