package pt.ipleiria.estg.dei.amsi.api;

import android.content.Context;
import android.content.SharedPreferences;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.listeners.EditProfileListener;
import pt.ipleiria.estg.dei.amsi.listeners.JogosListener;
import pt.ipleiria.estg.dei.amsi.listeners.LoginListener;
import pt.ipleiria.estg.dei.amsi.listeners.ProfileListener;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.api.models.Jogador;
import pt.ipleiria.estg.dei.amsi.utils.JsonParser;

public class SingletonAPI {

    private static SingletonAPI instance;
    private static RequestQueue volleyQueue;

    private LoginListener loginListener;
    private ProfileListener profileListener;
    private EditProfileListener editProfileListener;
    private JogosListener jogosListener;

    private static final String PREF_NAME = "LOGIN_PREFS";
    private static final String KEY_TOKEN = "TOKEN";

    private int jogadorId;

    private SingletonAPI(Context context) {
    }

    public static synchronized SingletonAPI getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonAPI(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    /* =========================
       URLS
       ========================= */

    private static final String BASE_URL = ApiConfig.BASE_URL;

    public String getLoginUrl() {
        return BASE_URL + "auth/login";
    }

    public String getJogadorUrl() {
        return BASE_URL + "jogador";
    }

    public String getJogosUrl() {
        return BASE_URL + "jogos";
    }

    /* =========================
       TOKEN
       ========================= */

    public static String getToken(Context context) {
        SharedPreferences sp = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        return sp.getString(KEY_TOKEN, null);
    }

    public static void saveToken(Context context, String token) {
        SharedPreferences sp = context.getSharedPreferences(PREF_NAME, Context.MODE_PRIVATE);
        sp.edit().putString(KEY_TOKEN, token).apply();
    }

    /* =========================
       LISTENERS
       ========================= */

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setProfileListener(ProfileListener profileListener) {
        this.profileListener = profileListener;
    }

    public void setEditProfileListener(EditProfileListener editProfileListener) {
        this.editProfileListener = editProfileListener;
    }

    public void setJogosListener(JogosListener jogosListener) {
        this.jogosListener = jogosListener;
    }

    public void setJogadorId(int jogadorId) {
        this.jogadorId = jogadorId;
    }

    public int getJogadorId() {
        return jogadorId;
    }

    /* =========================
       LOGIN
       ========================= */

    public void loginAPI(final String username, final String password, final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
        } else {

            StringRequest reqLogin = new StringRequest(
                    Request.Method.POST,
                    getLoginUrl(),
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {

                            String token = JsonParser.parseLoginToken(response);
                            int id = JsonParser.parseLoginId(response);

                            saveToken(context, token);
                            setJogadorId(id);

                            if (loginListener != null)
                                loginListener.onLoginSuccess();
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            if (loginListener != null)
                                loginListener.onLoginError();
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
    }

    /* =========================
       GET PERFIL
       ========================= */

    public void getProfileAPI(final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
        } else {

            StringRequest reqProfile = new StringRequest(
                    Request.Method.GET,
                    getJogadorUrl() + "/" + jogadorId,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {

                            Jogador jogador = JsonParser.parseJogador(response);

                            if (profileListener != null)
                                profileListener.onLoadProfile(jogador);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                        }
                    }
            ) {
                @Override
                public Map<String, String> getHeaders() {
                    Map<String, String> headers = new HashMap<>();
                    headers.put("Authorization", getToken(context));
                    return headers;
                }
            };

            volleyQueue.add(reqProfile);
        }
    }

    /* =========================
       EDITAR PERFIL
       ========================= */

    public void editProfileAPI(
            final String username,
            final String email,
            final String nome,
            final String idade,
            final Context context
    ) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
        } else {

            StringRequest reqEdit = new StringRequest(
                    Request.Method.PUT,
                    getJogadorUrl() + "/updatejogador/" + jogadorId,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            if (editProfileListener != null)
                                editProfileListener.editProfileSuccess();
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
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
                    headers.put("Authorization", getToken(context));
                    return headers;
                }
            };

            volleyQueue.add(reqEdit);
        }
    }

    /* =========================
       GET JOGOS
       ========================= */

    public void getJogosAPI(final Context context) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à Internet", Toast.LENGTH_LONG).show();
        } else {

            JsonArrayRequest reqJogos = new JsonArrayRequest(
                    Request.Method.GET,
                    getJogosUrl(),
                    null,
                    new Response.Listener<JSONArray>() {
                        @Override
                        public void onResponse(JSONArray response) {

                            ArrayList<JogoDefault> jogos = JsonParser.parseJogo(response);

                            if (jogosListener != null)
                                jogosListener.onRefreshListaJogos(jogos);
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                        }
                    }
            );

            volleyQueue.add(reqJogos);
        }
    }
}
