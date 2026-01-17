package pt.ipleiria.estg.dei.amsi.api;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
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

import pt.ipleiria.estg.dei.amsi.api.models.Categoria;
import pt.ipleiria.estg.dei.amsi.api.models.Dificuldade;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.api.models.Jogador;
import pt.ipleiria.estg.dei.amsi.listeners.CategoriasListener;
import pt.ipleiria.estg.dei.amsi.listeners.DificuldadesListener;
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
    private CategoriasListener categoriasListener;
    private DificuldadesListener dificuldadesListener;

    private static final String PREF_NAME = "LOGIN_PREFS";
    private static final String KEY_TOKEN = "TOKEN";
    private static final String SESSION_PREF = "user_session";

    private int jogadorId;

    private SingletonAPI(Context context) {
        SharedPreferences prefs =
                context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
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

    // =========================
    // URL HELPERS (DINÂMICOS)
    // =========================
    private String baseUrl(Context context) {
        return ApiConfig.getBaseUrl(context);
    }

    public String getLoginUrl(Context context) {
        return baseUrl(context) + "auth/login";
    }

    public String getSignupUrl(Context context) {
        return baseUrl(context) + "auth/signup";
    }

    public String getJogadorUrl(Context context) {
        return baseUrl(context) + "jogador";
    }

    public String getJogosUrl(Context context) {
        return baseUrl(context) + "jogodefault";
    }

    // =========================
    // TOKEN
    // =========================
    public static String getToken(Context context) {
        SharedPreferences sp =
                context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        return sp.getString(KEY_TOKEN, null);
    }

    public static void saveToken(Context context, String token) {
        SharedPreferences sp =
                context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        if (token == null) sp.edit().remove(KEY_TOKEN).apply();
        else sp.edit().putString(KEY_TOKEN, token).apply();
    }

    // =========================
    // LISTENERS
    // =========================
    public void setLoginListener(LoginListener l) { loginListener = l; }
    public void setSignupListener(SignupListener l) { signupListener = l; }
    public void setProfileListener(ProfileListener l) { profileListener = l; }
    public void setEditProfileListener(EditProfileListener l) { editProfileListener = l; }
    public void setJogosListener(JogosListener l) { jogosListener = l; }
    public void setCategoriasListener(CategoriasListener l) { categoriasListener = l; }
    public void setDificuldadesListener(DificuldadesListener l) { dificuldadesListener = l; }

    public int getJogadorId() { return jogadorId; }

    // =========================
    // SESSION
    // =========================
    private void saveFullSession(Context context, boolean logged,
                                 int userId, int jogadorId, String token) {

        saveToken(context, token);

        SharedPreferences sp =
                context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);

        sp.edit()
                .putBoolean("logged", logged)
                .putInt("user_id", userId)
                .putInt("jogador_id", jogadorId)
                .putString("token", token)
                .apply();

        this.jogadorId = jogadorId;
    }

    public void clearSession(Context context) {
        context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE)
                .edit().clear().apply();
        saveToken(context, null);
        jogadorId = 0;
    }

    // =========================
    // LOGIN
    // =========================
    public void loginAPI(String username, String password, Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest request = new StringRequest(
                Request.Method.POST,
                getLoginUrl(context),
                response -> {
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
                },
                error -> {
                    if (loginListener != null) loginListener.onLoginError();
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> p = new HashMap<>();
                p.put("username", username);
                p.put("password", password);
                return p;
            }
        };

        volleyQueue.add(request);
    }

    // =========================
    // SIGNUP
    // =========================
    public void signupAPI(String username, String nome, String idade,
                          String email, String password, Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest request = new StringRequest(
                Request.Method.POST,
                getSignupUrl(context),
                response -> {
                    try {
                        JSONObject json = new JSONObject(response);

                        if (!json.optBoolean("success", false)) {
                            if (signupListener != null)
                                signupListener.onSignupError(
                                        json.optString("error", "Erro"));
                            return;
                        }

                        String token = JsonParser.parseLoginToken(response);
                        int jogadorId = JsonParser.parseLoginId(response);
                        int userId = json.optInt("user_id", -1);

                        saveFullSession(context, true, userId, jogadorId, token);

                        if (signupListener != null)
                            signupListener.onSignupSuccess();

                    } catch (JSONException e) {
                        if (signupListener != null)
                            signupListener.onSignupError("Erro JSON");
                    }
                },
                error -> {
                    if (signupListener != null)
                        signupListener.onSignupError("Erro servidor");
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> p = new HashMap<>();
                p.put("username", username);
                p.put("nome", nome);
                p.put("idade", idade);
                p.put("email", email);
                p.put("password", password);
                return p;
            }
        };

        volleyQueue.add(request);
    }

    // =========================
    // PERFIL
    // =========================
    public void getProfileAPI(Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        if (jogadorId <= 0) {
            SharedPreferences prefs =
                    context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
            jogadorId = prefs.getInt("jogador_id", 0);
        }

        StringRequest request = new StringRequest(
                Request.Method.GET,
                getJogadorUrl(context) + "/" + jogadorId,
                response -> {
                    Jogador jogador = JsonParser.parseJogador(response);
                    if (profileListener != null)
                        profileListener.onLoadProfile(jogador);
                },
                error -> Toast.makeText(context,
                        "Erro ao carregar perfil",
                        Toast.LENGTH_LONG).show()
        );

        volleyQueue.add(request);
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
            SharedPreferences prefs =
                    context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
            jogadorId = prefs.getInt("jogador_id", 0);
        }

        if (jogadorId <= 0) {
            Toast.makeText(context,
                    "Sessão inválida. Faz login novamente.",
                    Toast.LENGTH_LONG).show();
            return;
        }

        StringRequest request = new StringRequest(
                Request.Method.PUT,
                getJogadorUrl(context) + "/updatejogador/" + jogadorId,
                response -> {
                    if (editProfileListener != null)
                        editProfileListener.editProfileSuccess();
                },
                error -> Toast.makeText(
                        context,
                        "Erro ao guardar perfil",
                        Toast.LENGTH_LONG).show()
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
        };

        volleyQueue.add(request);
    }



    // =========================
    // JOGOS
    // =========================
    public void getJogosAPI(Context context, Integer dificuldadeId, String search) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
            return;
        }

        String url;

        if (dificuldadeId != null && dificuldadeId > 0) {
            url = baseUrl(context)
                    + "dificuldade/"
                    + dificuldadeId
                    + "/jogosdefault";
        } else {
            url = getJogosUrl(context);
        }

        JsonArrayRequest request = new JsonArrayRequest(
                Request.Method.GET,
                url,
                null,
                response -> {
                    ArrayList<JogoDefault> jogos =
                            JsonParser.parseJogo(response);
                    if (jogosListener != null)
                        jogosListener.onRefreshListaJogos(jogos);
                },
                error -> Toast.makeText(
                        context,
                        "Erro ao carregar jogos",
                        Toast.LENGTH_LONG).show()
        );

        volleyQueue.add(request);
    }

    // =========================
    // DETALHES JOGO
    // =========================
    public void getJogoDetalhesAPI(int jogoId, Context context,
                                   final JogoDetalhesListener listener) {

        String url = getJogosUrl(context) + "/" + jogoId;

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.GET,
                url,
                null,
                response -> {
                    if (listener != null) listener.onResponse(response);
                },
                error -> {
                    Toast.makeText(context,
                            "Erro ao carregar detalhes do jogo",
                            Toast.LENGTH_LONG).show();
                }
        );

        volleyQueue.add(request);
    }

    public interface JogoDetalhesListener {
        void onResponse(JSONObject response);
    }

    // =========================
    // PERGUNTAS
    // =========================
    public void getPerguntasJogoAPI(int jogoId, Context context,
                                    VolleyCallback callback) {

        String url =
                baseUrl(context)
                        + "pergunta/jogar?id_jogo="
                        + jogoId;

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.GET,
                url,
                null,
                response -> callback.onResponse(response),
                error -> {
                    Toast.makeText(context,
                            "Erro ao carregar perguntas",
                            Toast.LENGTH_LONG).show();
                    callback.onResponse(null);
                }
        );

        volleyQueue.add(request);
    }

    public interface VolleyCallback {
        void onResponse(JSONObject result);
    }

    // =========================
    // CATEGORIAS
    // =========================
    public void getCategoriasAPI(Context context) {

        JsonArrayRequest request = new JsonArrayRequest(
                Request.Method.GET,
                baseUrl(context) + "categoria",
                null,
                response -> {
                    ArrayList<Categoria> categorias =
                            JsonParser.parseCategorias(response);
                    if (categoriasListener != null)
                        categoriasListener.onRefreshCategorias(categorias);
                },
                error -> Toast.makeText(
                        context,
                        "Erro ao carregar categorias",
                        Toast.LENGTH_LONG).show()
        );

        volleyQueue.add(request);
    }

    // =========================
    // DIFICULDADES
    // =========================
    public void getDificuldadesAPI(Context context) {

        JsonArrayRequest request = new JsonArrayRequest(
                Request.Method.GET,
                baseUrl(context) + "dificuldade",
                null,
                response -> {
                    ArrayList<Dificuldade> dificuldades =
                            JsonParser.parseDificuldades(response);
                    if (dificuldadesListener != null)
                        dificuldadesListener.onRefreshDificuldades(dificuldades);
                },
                error -> Toast.makeText(
                        context,
                        "Erro ao carregar dificuldades",
                        Toast.LENGTH_LONG).show()
        );

        volleyQueue.add(request);
    }
}
