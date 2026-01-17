package pt.ipleiria.estg.dei.amsi.api;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.api.models.Jogador;
import pt.ipleiria.estg.dei.amsi.listeners.EditProfileListener;
import pt.ipleiria.estg.dei.amsi.listeners.JogosListener;
import pt.ipleiria.estg.dei.amsi.listeners.LoginListener;
import pt.ipleiria.estg.dei.amsi.listeners.ProfileListener;
import pt.ipleiria.estg.dei.amsi.listeners.SignupListener;
import pt.ipleiria.estg.dei.amsi.utils.JsonParser;

public class SingletonAPI {

    private static SingletonAPI instance;
    private static RequestQueue volleyQueue;

    private LoginListener loginListener;
    private SignupListener signupListener;
    private ProfileListener profileListener;
    private EditProfileListener editProfileListener;
    private JogosListener jogosListener;

    private static final String PREF_NAME = "LOGIN_PREFS";
    private static final String KEY_TOKEN = "TOKEN";

    private static final String SESSION_PREF = "user_session";

    private int jogadorId;

    private SingletonAPI(Context context) {
        // ✅ carrega o jogadorId guardado (evita /jogador/0)
        SharedPreferences prefs = context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
        this.jogadorId = prefs.getInt("jogador_id", 0);
    }

    public static synchronized SingletonAPI getInstance(Context context) {
        if (instance == null) {
            Context appCtx = context.getApplicationContext();
            instance = new SingletonAPI(appCtx);
            volleyQueue = Volley.newRequestQueue(appCtx);
        }
        return instance;
    }

    private static final String BASE_URL = ApiConfig.BASE_URL;

    public String getLoginUrl() { return BASE_URL + "auth/login"; }
    public String getSignupUrl() { return BASE_URL + "auth/signup"; }
    public String getJogadorUrl() { return BASE_URL + "jogador"; }
    public String getJogosUrl() { return BASE_URL + "jogodefault"; }

    public static String getToken(Context context) {
        SharedPreferences sp = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        return sp.getString(KEY_TOKEN, null);
    }

    public static void saveToken(Context context, String token) {
        SharedPreferences sp = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        if (token == null) sp.edit().remove(KEY_TOKEN).apply();
        else sp.edit().putString(KEY_TOKEN, token).apply();
    }

    public void setLoginListener(LoginListener loginListener) { this.loginListener = loginListener; }
    public void setSignupListener(SignupListener signupListener) { this.signupListener = signupListener; }
    public void setProfileListener(ProfileListener profileListener) { this.profileListener = profileListener; }
    public void setEditProfileListener(EditProfileListener editProfileListener) { this.editProfileListener = editProfileListener; }
    public void setJogosListener(JogosListener jogosListener) { this.jogosListener = jogosListener; }

    public int getJogadorId() { return jogadorId; }

    private void saveFullSession(Context context, boolean logged, int userId, int jogadorId, String token) {
        if (token != null) saveToken(context, token);

        SharedPreferences prefs = context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
        prefs.edit()
                .putBoolean("logged", logged)
                .putInt("user_id", userId)
                .putInt("jogador_id", jogadorId)
                .putString("token", token)
                .apply();

        this.jogadorId = jogadorId;
    }

    // =========================
    // LOGIN
    // =========================
    public void loginAPI(final String username, final String password, final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest reqLogin = new StringRequest(
                Request.Method.POST,
                getLoginUrl(),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject json = new JSONObject(response);

                            if (!json.optBoolean("success", false)) {
                                if (loginListener != null) loginListener.onLoginError();
                                return;
                            }

                            String token = JsonParser.parseLoginToken(response);
                            int jogadorId = JsonParser.parseLoginId(response);
                            int userId = json.optInt("user_id", -1);

                            saveFullSession(context, true, userId, jogadorId, token);

                            if (loginListener != null) loginListener.onLoginSuccess();

                        } catch (JSONException e) {
                            if (loginListener != null) loginListener.onLoginError();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        if (loginListener != null) loginListener.onLoginError();
                    }
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("password", password);
                return params;
            }
        };

        volleyQueue.add(reqLogin);
    }

    // =========================
    // SIGNUP
    // =========================
    public void signupAPI(final String username,
                          final String nome,
                          final String idade,
                          final String email,
                          final String password,
                          final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest reqSignup = new StringRequest(
                Request.Method.POST,
                getSignupUrl(),
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject json = new JSONObject(response);

                            if (!json.optBoolean("success", false)) {
                                String msg = json.optString("error", "Erro ao criar conta");
                                if (signupListener != null) signupListener.onSignupError(msg);
                                return;
                            }

                            String token = JsonParser.parseLoginToken(response);
                            int jogadorId = JsonParser.parseLoginId(response);
                            int userId = json.optInt("user_id", -1);

                            saveFullSession(context, true, userId, jogadorId, token);

                            if (signupListener != null) signupListener.onSignupSuccess();

                        } catch (JSONException e) {
                            if (signupListener != null) signupListener.onSignupError("Erro ao processar resposta");
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        String msg = "Erro de ligação ao servidor";
                        if (error != null && error.getMessage() != null && !error.getMessage().isEmpty()) {
                            msg = error.getMessage();
                        }
                        if (signupListener != null) signupListener.onSignupError(msg);
                    }
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("nome", nome);
                params.put("idade", idade);
                params.put("email", email);
                params.put("password", password);
                return params;
            }
        };

        volleyQueue.add(reqSignup);
    }

    // =========================
    // GET PERFIL
    // =========================
    public void getProfileAPI(final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        // ✅ garante que usa o jogadorId guardado
        if (jogadorId <= 0) {
            SharedPreferences prefs = context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
            jogadorId = prefs.getInt("jogador_id", 0);
        }

        if (jogadorId <= 0) {
            Toast.makeText(context, "Sessão inválida (jogador_id em falta). Faz login novamente.", Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest reqProfile = new StringRequest(
                Request.Method.GET,
                getJogadorUrl() + "/" + jogadorId,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Jogador jogador = JsonParser.parseJogador(response);
                        if (profileListener != null) profileListener.onLoadProfile(jogador);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        String msg = "Erro ao carregar perfil";
                        if (error != null && error.getMessage() != null && !error.getMessage().isEmpty()) {
                            msg = error.getMessage();
                        }
                        Toast.makeText(context, msg, Toast.LENGTH_LONG).show();
                    }
                }
        ) {
            @Override
            public Map<String, String> getHeaders() {
                Map<String, String> headers = new HashMap<>();
                String token = context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE)
                        .getString("token", null);
                if (token != null && !token.isEmpty()) {
                    headers.put("Authorization", token);
                }
                return headers;
            }
        };

        volleyQueue.add(reqProfile);
    }

    // =========================
    // EDITAR PERFIL
    // =========================
    public void editProfileAPI(final String username,
                               final String email,
                               final String nome,
                               final String idade,
                               final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        if (jogadorId <= 0) {
            SharedPreferences prefs = context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
            jogadorId = prefs.getInt("jogador_id", 0);
        }

        StringRequest reqEdit = new StringRequest(
                Request.Method.PUT,
                getJogadorUrl() + "/updatejogador/" + jogadorId,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        if (editProfileListener != null) editProfileListener.editProfileSuccess();
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        String msg = "Erro ao guardar dados";
                        if (error != null && error.getMessage() != null && !error.getMessage().isEmpty()) {
                            msg = error.getMessage();
                        }
                        Toast.makeText(context, msg, Toast.LENGTH_LONG).show();
                    }
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("username", username);
                params.put("email", email);
                params.put("nome", nome);
                params.put("idade", idade);
                return params;
            }

            @Override
            public Map<String, String> getHeaders() {
                Map<String, String> headers = new HashMap<>();
                String token = context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE)
                        .getString("token", null);
                if (token != null && !token.isEmpty()) {
                    headers.put("Authorization", token);
                }
                return headers;
            }
        };

        volleyQueue.add(reqEdit);
    }

    // =========================
    // GET JOGOS
    // =========================
    public void getJogosAPI(final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        JsonArrayRequest reqJogos = new JsonArrayRequest(
                Request.Method.GET,
                getJogosUrl(),
                null,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        ArrayList<JogoDefault> jogos = JsonParser.parseJogo(response);
                        if (jogosListener != null) jogosListener.onRefreshListaJogos(jogos);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        String msg = "Erro ao carregar jogos";
                        if (error != null && error.getMessage() != null && !error.getMessage().isEmpty()) {
                            msg = error.getMessage();
                        }
                        Toast.makeText(context, msg, Toast.LENGTH_LONG).show();
                    }
                }
        );

        volleyQueue.add(reqJogos);
    }

    // =========================
    // LOGOUT LOCAL (para usares no ProfileFragment)
    // =========================
    public void clearSession(Context context) {
        context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE).edit().clear().apply();
        saveToken(context, null);
        this.jogadorId = 0;
    }

    public void getJogoDetalhesAPI(int jogoId, Context context, final JogoDetalhesListener listener) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        String url = getJogosUrl() + "/" + jogoId;

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.GET,
                url,
                null,
                response -> {
                    if (listener != null) listener.onResponse(response);
                },
                error -> {
                    error.printStackTrace();
                    Toast.makeText(context, "Erro ao carregar detalhes do jogo", Toast.LENGTH_LONG).show();
                }
        );

        volleyQueue.add(request);
    }

    // Interface callback
    public interface JogoDetalhesListener {
        void onResponse(JSONObject response);
    }
}
