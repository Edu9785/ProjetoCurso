package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.content.SharedPreferences;
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

import com.android.volley.Request;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import pt.ipleiria.estg.dei.amsi.api.ApiConfig;

public class ProfileFragment extends Fragment {

    private EditText edtUsername, edtName, edtAge, edtEmail;
    private Button btnEditProfile, btnSaveProfile, btnCancelEdit, btnLogout, btnDeleteAccount;
    private View layoutEditActions;

    private int jogadorId;
    private String token;

    // Valores originais (para cancelar edição)
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

        // UI
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

        // Sessão
        SharedPreferences prefs =
                requireActivity().getSharedPreferences("user_session", getActivity().MODE_PRIVATE);

        jogadorId = prefs.getInt("jogador_id", -1);
        token = prefs.getString("token", null);

        setEditable(false);
        loadProfile();

        // ✏️ Editar
        btnEditProfile.setOnClickListener(v -> {
            setEditable(true);
            btnEditProfile.setVisibility(View.GONE);
            layoutEditActions.setVisibility(View.VISIBLE);
        });

        // 💾 Guardar
        btnSaveProfile.setOnClickListener(v -> saveProfile());

        // ❌ Cancelar
        btnCancelEdit.setOnClickListener(v -> {
            restoreOriginalValues();
            setEditable(false);
            layoutEditActions.setVisibility(View.GONE);
            btnEditProfile.setVisibility(View.VISIBLE);
        });

        // 🚪 Logout
        btnLogout.setOnClickListener(v -> logoutApi());

        // 🗑 Eliminar conta
        btnDeleteAccount.setOnClickListener(v -> confirmDeleteAccount());

        return view;
    }

    // =========================
    // GET PERFIL
    // =========================
    private void loadProfile() {

        String url = ApiConfig.BASE_URL + "jogador/" + jogadorId;

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.GET,
                url,
                null,
                response -> {
                    try {
                        originalUsername = response.getString("username");
                        originalNome = response.getString("nome");
                        originalIdade = response.getInt("idade");
                        originalEmail = response.getString("email");

                        edtUsername.setText(originalUsername);
                        edtName.setText(originalNome);
                        edtAge.setText(String.valueOf(originalIdade));
                        edtEmail.setText(originalEmail);

                    } catch (JSONException e) {
                        Toast.makeText(getContext(), "Erro ao carregar perfil", Toast.LENGTH_SHORT).show();
                    }
                },
                error -> Toast.makeText(getContext(), "Erro de ligação à API", Toast.LENGTH_SHORT).show()
        ) {
            @Override
            public java.util.Map<String, String> getHeaders() {
                java.util.Map<String, String> headers = new java.util.HashMap<>();
                headers.put("Authorization", token);
                return headers;
            }
        };

        Volley.newRequestQueue(requireContext()).add(request);
    }

    // =========================
    // PUT PERFIL
    // =========================
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

        int idade = Integer.parseInt(idadeStr);

        JSONObject body = new JSONObject();
        try {
            body.put("username", username);
            body.put("nome", nome);
            body.put("idade", idade);
            body.put("email", email);
        } catch (JSONException ignored) {}

        String url = ApiConfig.BASE_URL + "jogador/updatejogador/" + jogadorId;

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.PUT,
                url,
                body,
                response -> {
                    Toast.makeText(getContext(), "Perfil atualizado com sucesso", Toast.LENGTH_SHORT).show();
                    setEditable(false);
                    layoutEditActions.setVisibility(View.GONE);
                    btnEditProfile.setVisibility(View.VISIBLE);
                },
                error -> Toast.makeText(getContext(), "Erro ao guardar dados", Toast.LENGTH_SHORT).show()
        ) {
            @Override
            public java.util.Map<String, String> getHeaders() {
                java.util.Map<String, String> headers = new java.util.HashMap<>();
                headers.put("Authorization", token);
                headers.put("Content-Type", "application/json");
                return headers;
            }
        };

        Volley.newRequestQueue(requireContext()).add(request);
    }

    // =========================
    // ELIMINAR CONTA
    // =========================
    private void confirmDeleteAccount() {

        new AlertDialog.Builder(requireContext())
                .setTitle("Eliminar conta")
                .setMessage("Tens a certeza que queres eliminar a tua conta? Esta ação é irreversível.")
                .setPositiveButton("Eliminar", (dialog, which) -> deleteAccountApi())
                .setNegativeButton("Cancelar", null)
                .show();
    }

    private void deleteAccountApi() {

        String url = ApiConfig.BASE_URL + "jogador/" + jogadorId;

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.DELETE,
                url,
                null,
                response -> {
                    SharedPreferences prefs =
                            requireActivity().getSharedPreferences("user_session", getActivity().MODE_PRIVATE);

                    prefs.edit().clear().apply();

                    Toast.makeText(getContext(), "Conta eliminada com sucesso", Toast.LENGTH_SHORT).show();

                    startActivity(new Intent(getActivity(), WelcomeActivity.class));
                    requireActivity().finish();
                },
                error -> Toast.makeText(getContext(), "Erro ao eliminar conta", Toast.LENGTH_SHORT).show()
        ) {
            @Override
            public java.util.Map<String, String> getHeaders() {
                java.util.Map<String, String> headers = new java.util.HashMap<>();
                headers.put("Authorization", token);
                return headers;
            }
        };

        Volley.newRequestQueue(requireContext()).add(request);
    }

    // =========================
    // LOGOUT
    // =========================
    private void logoutApi() {

        String url = ApiConfig.BASE_URL + "auth/logout";

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.POST,
                url,
                null,
                response -> {
                    SharedPreferences prefs =
                            requireActivity().getSharedPreferences("user_session", getActivity().MODE_PRIVATE);

                    prefs.edit().clear().apply();

                    startActivity(new Intent(getActivity(), WelcomeActivity.class));
                    requireActivity().finish();
                },
                error -> Toast.makeText(getContext(), "Erro ao efetuar logout", Toast.LENGTH_SHORT).show()
        ) {
            @Override
            public java.util.Map<String, String> getHeaders() {
                java.util.Map<String, String> headers = new java.util.HashMap<>();
                headers.put("Authorization", token);
                return headers;
            }
        };

        Volley.newRequestQueue(requireContext()).add(request);
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
