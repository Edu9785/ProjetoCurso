package pt.ipleiria.estg.dei.amsi.api;

import android.content.Context;
import android.content.SharedPreferences;
import android.database.sqlite.SQLiteDatabase;
import android.net.Uri;
import android.util.Log;
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
import pt.ipleiria.estg.dei.amsi.api.models.Pergunta;
import pt.ipleiria.estg.dei.amsi.api.models.Resposta;
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

    private JogoDefault jogo;

    private int jogadorId;

    private DBHelper dbHelper;

    private SingletonAPI(Context context) {
        SharedPreferences prefs =
                context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);
        this.jogadorId = prefs.getInt("jogador_id", 0);
        dbHelper = new DBHelper(context);
        SQLiteDatabase db = dbHelper.getWritableDatabase();
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

        SharedPreferences prefs =
                context.getSharedPreferences(SESSION_PREF, Context.MODE_PRIVATE);

        jogadorId = prefs.getInt("jogador_id", 0);
        String token = prefs.getString("token", "");

        Log.d("TOKEN_ANDROID", token);

        if (jogadorId <= 0 || token.isEmpty()) {
            Toast.makeText(context,
                    "Sessão inválida. Faz login novamente.",
                    Toast.LENGTH_LONG).show();
            return;
        }

        String url = getJogadorUrl(context) + "/updatejogador/" + jogadorId;

        JSONObject jsonBody = new JSONObject();
        try {
            jsonBody.put("username", username);
            jsonBody.put("email", email);
            jsonBody.put("nome", nome);
            jsonBody.put("idade", idade);
        } catch (JSONException e) {
            e.printStackTrace();
            return;
        }

        JsonObjectRequest request = new JsonObjectRequest(
                Request.Method.PUT,
                url,
                jsonBody,
                response -> {
                    if (editProfileListener != null) {
                        editProfileListener.editProfileSuccess();
                    }
                },
                error -> {

                    if (error.networkResponse != null && error.networkResponse.data != null) {
                        String responseBody = new String(error.networkResponse.data);
                        Log.e("VOLLEY_ERROR", responseBody);
                    }

                    error.printStackTrace();

                    Toast.makeText(context,
                            "Erro ao guardar perfil",
                            Toast.LENGTH_LONG).show();
                }
        ) {
            @Override
            public Map<String, String> getHeaders() {
                Map<String, String> headers = new HashMap<>();
                headers.put("Content-Type", "application/json; charset=utf-8");
                headers.put("Authorization", "Bearer " + token);
                return headers;
            }
        };

        volleyQueue.add(request);
    }


    // =========================
    // JOGOS
    // =========================
    public void getJogosAPI(final Context context, Integer dificuldadeId, String search) {

        final DBHelper dbHelper = new DBHelper(context);

        // OFFLINE
        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context,
                    "Sem ligação à Internet. A mostrar jogos offline.",
                    Toast.LENGTH_LONG).show();

            ArrayList<JogoDefault> jogosOffline = dbHelper.mostrarJogos();

            if (jogosListener != null)
                jogosListener.onRefreshListaJogos(jogosOffline);

            return;
        }

        // ONLINE
        String url = baseUrl(context) + "jogodefault";
        boolean hasQuery = false;

        //filtro por dificuldade
        if (dificuldadeId != null && dificuldadeId > 0) {
            url += "?dificuldade=" + dificuldadeId;
            hasQuery = true;
        }

        // pesquisa por título
        if (search != null && !search.isEmpty()) {
            url += (hasQuery ? "&" : "?") + "search=" + Uri.encode(search);
        }

        // DEBUG (opcional, mas recomendado)
        Log.d("API_JOGOS_URL", url);

        JsonArrayRequest reqJogos = new JsonArrayRequest(
                Request.Method.GET,
                url,
                null,
                response -> {
                    ArrayList<JogoDefault> jogos = JsonParser.parseJogo(response);

                    for (final JogoDefault jogo : jogos) {

                        // Inserir jogo se ainda não existe
                        if (!dbHelper.jogoExiste(jogo.getId())) {
                            dbHelper.inserirJogo(jogo);
                        }

                        // Inserir categorias do jogo e relacionamento
                        if (jogo.getCategorias() != null) {
                            for (Categoria c : jogo.getCategorias()) {
                                dbHelper.inserirCategoria(c); // garante que a categoria existe
                                dbHelper.inserirJogoCategoria(jogo.getId(), c.getId()); // relaciona jogo-categoria
                            }
                        }

                        // Inserir jogo se ainda não existe
                        if (!dbHelper.jogoExiste(jogo.getId())) {
                            dbHelper.inserirJogo(jogo);
                        }

                        // Buscar e inserir perguntas e respostas sempre
                        String urlPerguntas = baseUrl(context) + "pergunta/jogar?id_jogo=" + jogo.getId();

                        JsonObjectRequest reqPerguntas = new JsonObjectRequest(
                                Request.Method.GET,
                                urlPerguntas,
                                null,
                                responsePerguntas -> {
                                    try {
                                        if (!responsePerguntas.has("perguntas")) return;

                                        JSONArray perguntasArray = responsePerguntas.getJSONArray("perguntas");

                                        for (int i = 0; i < perguntasArray.length(); i++) {
                                            JSONObject pObj = perguntasArray.getJSONObject(i);
                                            int perguntaId = pObj.getInt("id");

                                            Pergunta p = new Pergunta(
                                                    perguntaId,
                                                    pObj.getString("pergunta"),
                                                    pObj.getInt("valor")
                                            );

                                            if (!dbHelper.perguntaExiste(perguntaId)) {
                                                dbHelper.inserirPergunta(p, jogo.getId());
                                            }

                                            JSONArray respostasArray = pObj.getJSONArray("respostas");

                                            for (int j = 0; j < respostasArray.length(); j++) {
                                                JSONObject rObj = respostasArray.getJSONObject(j);
                                                int respostaId = rObj.getInt("id");

                                                Resposta r = new Resposta(
                                                        respostaId,
                                                        rObj.getString("resposta"),
                                                        rObj.getBoolean("correta")
                                                );

                                                if (!dbHelper.respostaExiste(respostaId)) {
                                                    dbHelper.inserirResposta(r, perguntaId);
                                                }
                                            }
                                        }
                                    } catch (Exception e) {
                                        e.printStackTrace();
                                    }
                                },
                                error -> {
                                    // Falha ao buscar perguntas
                                }
                        );

                        volleyQueue.add(reqPerguntas);
                    }

                    // Retorna lista de jogos para o listener
                    if (jogosListener != null)
                        jogosListener.onRefreshListaJogos(jogos);

                },
                error -> {
                    Toast.makeText(context, "Erro ao carregar jogos", Toast.LENGTH_LONG).show();
                }
        );

        volleyQueue.add(reqJogos);
    }



    // =========================
    // DETALHES JOGO
    // =========================
    public void getJogoDetalhesAPI(final int jogoId,
                                   final Context context,
                                   final JogoDetalhesListener listener) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context,
                    "Sem ligação à Internet",
                    Toast.LENGTH_LONG).show();

            jogo=dbHelper.verJogo(jogoId);

            try {
                JSONObject jogoObj = new JSONObject();
                jogoObj.put("id", jogo.getId());
                jogoObj.put("titulo", jogo.getTitulo());
                jogoObj.put("descricao", jogo.getDescricao());
                jogoObj.put("imagem", jogo.getImagem());
                jogoObj.put("totalpontosjogo", jogo.getTotalpontosjogo());

                // Dificuldade
                if (jogo.getDificuldade() != null) {
                    JSONObject difObj = new JSONObject();
                    difObj.put("id", jogo.getDificuldade().getId());
                    difObj.put("dificuldade", jogo.getDificuldade().getDificuldade());
                    jogoObj.put("dificuldade", difObj);
                }

                // Categorias
                JSONArray catArray = new JSONArray();
                if (jogo.getCategorias() != null) {
                    for (Categoria c : jogo.getCategorias()) {
                        JSONObject cObj = new JSONObject();
                        cObj.put("id", c.getId());
                        cObj.put("categoria", c.getCategoria());
                        catArray.put(cObj);
                    }
                }
                jogoObj.put("categorias", catArray);

                if (listener != null)
                    listener.onResponse(jogoObj);

            } catch (Exception e) {
                throw new RuntimeException(e);
            }
        } else {

            String url = getJogosUrl(context) + "/" + jogoId;

            JsonObjectRequest reqDetalhes = new JsonObjectRequest(
                    Request.Method.GET,
                    url,
                    null,
                    new com.android.volley.Response.Listener<JSONObject>() {
                        @Override
                        public void onResponse(JSONObject response) {
                            if (listener != null)
                                listener.onResponse(response);
                        }
                    },
                    new com.android.volley.Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(com.android.volley.VolleyError error) {
                            Toast.makeText(context,
                                    "Erro ao carregar detalhes do jogo",
                                    Toast.LENGTH_LONG).show();
                        }
                    }
            );

            volleyQueue.add(reqDetalhes);
        }
    }

    public interface JogoDetalhesListener {
        void onResponse(JSONObject response);
    }

    // =========================
    // PERGUNTAS
    // =========================
    public void getPerguntasJogoAPI(final int jogoId,
                                    final Context context,
                                    final VolleyCallback callback) {

        if (!JsonParser.isConnectionInternet(context)) {
            Toast.makeText(context,
                    "Sem ligação à Internet",
                    Toast.LENGTH_LONG).show();

            // 🔹 Usar método jogarJogo() do DBHelper
            ArrayList<Pergunta> perguntas = dbHelper.jogarJogo(jogoId);
            JSONArray perguntasArray = new JSONArray();

            try {
                for (Pergunta p : perguntas) {
                    JSONObject pObj = new JSONObject();
                    pObj.put("id", p.getId());
                    pObj.put("pergunta", p.getPergunta());
                    pObj.put("valor", p.getValor());

                    JSONArray respostasArray = new JSONArray();
                    for (Resposta r : p.getRespostas()) { // já está carregado no jogarJogo
                        JSONObject rObj = new JSONObject();
                        rObj.put("id", r.getId());
                        rObj.put("resposta", r.getResposta());
                        rObj.put("correta", r.isCorreta());
                        respostasArray.put(rObj);
                    }

                    pObj.put("respostas", respostasArray);
                    perguntasArray.put(pObj);
                }

                JSONObject result = new JSONObject();
                result.put("perguntas", perguntasArray);

                callback.onResponse(result);

            } catch (Exception e) {
                e.printStackTrace();
                Toast.makeText(context, "Erro ao carregar perguntas offline", Toast.LENGTH_LONG).show();
                callback.onResponse(null);
            }

        } else {
            // 🔹 Online (API)
            String url = baseUrl(context) + "pergunta/jogar?id_jogo=" + jogoId;

            JsonObjectRequest reqPerguntas = new JsonObjectRequest(
                    Request.Method.GET,
                    url,
                    null,
                    response -> {
                        // opcional: salvar offline aqui
                        callback.onResponse(response);
                    },
                    error -> {
                        Toast.makeText(context,
                                "Erro ao carregar perguntas",
                                Toast.LENGTH_LONG).show();
                        callback.onResponse(null);
                    }
            );

            volleyQueue.add(reqPerguntas);
        }
    }



    public interface VolleyCallback {
        void onResponse(JSONObject result);
    }

    // =========================
    // CATEGORIAS OFFLINE/ONLINE
    // =========================
    public void getCategoriasAPI(final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            ArrayList<Categoria> categorias = dbHelper.mostrarCategorias(); // Implementar método em DBHelper
            if (categoriasListener != null) categoriasListener.onRefreshCategorias(categorias);
            return;
        }

        JsonArrayRequest reqCategorias = new JsonArrayRequest(Request.Method.GET, baseUrl(context) + "categoria", null,
                response -> {
                    ArrayList<Categoria> categorias = JsonParser.parseCategorias(response);

                    // SALVAR OFFLINE
                    for (Categoria c : categorias) {
                        dbHelper.inserirCategoria(c);
                    }

                    if (categoriasListener != null) categoriasListener.onRefreshCategorias(categorias);
                },
                error -> Toast.makeText(context, "Erro ao carregar categorias", Toast.LENGTH_LONG).show()
        );

        volleyQueue.add(reqCategorias);
    }

    // =========================
    // DIFICULDADES OFFLINE/ONLINE
    // =========================
    public void getDificuldadesAPI(final Context context) {
        if (!JsonParser.isConnectionInternet(context)) {
            ArrayList<Dificuldade> dificuldades = dbHelper.mostrarDificuldades(); // Implementar método em DBHelper
            if (dificuldadesListener != null) dificuldadesListener.onRefreshDificuldades(dificuldades);
            return;
        }

        JsonArrayRequest reqDificuldades = new JsonArrayRequest(Request.Method.GET, baseUrl(context) + "dificuldade", null,
                response -> {
                    ArrayList<Dificuldade> dificuldades = JsonParser.parseDificuldades(response);

                    // SALVAR OFFLINE
                    for (Dificuldade d : dificuldades) {
                        dbHelper.inserirDificuldade(d);
                    }

                    if (dificuldadesListener != null) dificuldadesListener.onRefreshDificuldades(dificuldades);
                },
                error -> Toast.makeText(context, "Erro ao carregar dificuldades", Toast.LENGTH_LONG).show()
        );

        volleyQueue.add(reqDificuldades);
    }
}
