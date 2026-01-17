package pt.ipleiria.estg.dei.amsi.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

import pt.ipleiria.estg.dei.amsi.api.models.Categoria;
import pt.ipleiria.estg.dei.amsi.api.models.Dificuldade;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.api.models.Jogador;

public class JsonParser {

    public static String parseLoginToken(String response) {
        try {
            JSONObject json = new JSONObject(response);
            return json.getString("token");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static int parseLoginId(String response) {
        try {
            JSONObject json = new JSONObject(response);
            return json.getInt("jogador_id"); // Ajusta se necessário
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    // Parser Jogador (mesmo padrão sem setters)
    public static Jogador parseJogador(String response) {
        Jogador jogador = null;
        try {
            JSONObject json = new JSONObject(response);

            int id = json.getInt("id");
            String nome = json.getString("nome");
            int idade = json.getInt("idade");
            int id_premium = json.optInt("id_premium", 0);

            // Dados user
            int id_user = json.getInt("id_user");
            String email = json.getString("email");

            jogador = new JogadorWrapper(id, nome, idade, id_premium, id_user, email).toJogador();

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return jogador;
    }

    // Wrapper para setar campos privados via reflection (pois modelo só tem getters)
    private static class JogadorWrapper {
        int id, idade, id_premium, id_user;
        String nome, email;

        JogadorWrapper(int id, String nome, int idade, int id_premium, int id_user, String email) {
            this.id = id;
            this.nome = nome;
            this.idade = idade;
            this.id_premium = id_premium;
            this.id_user = id_user;
            this.email = email;
        }

        Jogador toJogador() {
            Jogador j = new Jogador();
            try {
                java.lang.reflect.Field f;

                f = Jogador.class.getDeclaredField("id");
                f.setAccessible(true);
                f.setInt(j, id);

                f = Jogador.class.getDeclaredField("nome");
                f.setAccessible(true);
                f.set(j, nome);

                f = Jogador.class.getDeclaredField("idade");
                f.setAccessible(true);
                f.setInt(j, idade);

                f = Jogador.class.getDeclaredField("id_premium");
                f.setAccessible(true);
                f.setInt(j, id_premium);

                f = Jogador.class.getDeclaredField("id_user");
                f.setAccessible(true);
                f.setInt(j, id_user);

                f = Jogador.class.getDeclaredField("email");
                f.setAccessible(true);
                f.set(j, email);

            } catch (NoSuchFieldException | IllegalAccessException e) {
                throw new RuntimeException(e);
            }
            return j;
        }
    }

    // ======================
    // PARSER JOGOS
    // ======================
    public static ArrayList<JogoDefault> parseJogo(JSONArray response) {
        ArrayList<JogoDefault> jogos = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject jsonJogo = response.getJSONObject(i);

                int id = jsonJogo.getInt("id");
                String titulo = jsonJogo.getString("titulo");
                String descricao = jsonJogo.getString("descricao");
                String imagem = jsonJogo.optString("imagem", "");

                // Dificuldade (objeto)
                Dificuldade dificuldade = null;
                if (jsonJogo.has("dificuldade") && !jsonJogo.isNull("dificuldade")) {
                    JSONObject jsonDificuldade = jsonJogo.getJSONObject("dificuldade");
                    int difId = jsonDificuldade.getInt("id");
                    String difNome = jsonDificuldade.getString("dificuldade");

                    dificuldade = new DificuldadeWrapper(difId, difNome).toDificuldade();
                }

                // Categorias (array)
                List<Categoria> categorias = new ArrayList<>();
                if (jsonJogo.has("categorias") && !jsonJogo.isNull("categorias")) {
                    JSONArray jsonCategorias = jsonJogo.getJSONArray("categorias");
                    for (int j = 0; j < jsonCategorias.length(); j++) {
                        JSONObject jsonCategoria = jsonCategorias.getJSONObject(j);
                        int catId = jsonCategoria.getInt("id");
                        String catNome = jsonCategoria.getString("categoria");
                        categorias.add(new CategoriaWrapper(catId, catNome).toCategoria());
                    }
                }

                // Montar JogoDefault (sem setters, usando wrapper/reflection)
                JogoDefault jogo = new JogoDefaultWrapper(id, titulo, descricao, imagem, dificuldade, categorias).toJogoDefault();

                jogos.add(jogo);

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return jogos;
    }

    // Wrappers para preencher campos privados
    private static class DificuldadeWrapper {
        int id;
        String dificuldade;

        DificuldadeWrapper(int id, String dificuldade) {
            this.id = id;
            this.dificuldade = dificuldade;
        }

        Dificuldade toDificuldade() {
            Dificuldade d = new Dificuldade();
            try {
                java.lang.reflect.Field f;

                f = Dificuldade.class.getDeclaredField("id");
                f.setAccessible(true);
                f.setInt(d, id);

                f = Dificuldade.class.getDeclaredField("dificuldade");
                f.setAccessible(true);
                f.set(d, dificuldade);

            } catch (NoSuchFieldException | IllegalAccessException e) {
                throw new RuntimeException(e);
            }
            return d;
        }
    }

    private static class CategoriaWrapper {
        int id;
        String categoria;

        CategoriaWrapper(int id, String categoria) {
            this.id = id;
            this.categoria = categoria;
        }

        Categoria toCategoria() {
            Categoria c = new Categoria();
            try {
                java.lang.reflect.Field f;

                f = Categoria.class.getDeclaredField("id");
                f.setAccessible(true);
                f.setInt(c, id);

                f = Categoria.class.getDeclaredField("categoria");
                f.setAccessible(true);
                f.set(c, categoria);

            } catch (NoSuchFieldException | IllegalAccessException e) {
                throw new RuntimeException(e);
            }
            return c;
        }
    }

    private static class JogoDefaultWrapper {
        int id;
        String titulo;
        String descricao;
        String imagem;
        Dificuldade dificuldade;
        List<Categoria> categorias;

        JogoDefaultWrapper(int id, String titulo, String descricao, String imagem, Dificuldade dificuldade, List<Categoria> categorias) {
            this.id = id;
            this.titulo = titulo;
            this.descricao = descricao;
            this.imagem = imagem;
            this.dificuldade = dificuldade;
            this.categorias = categorias;
        }

        JogoDefault toJogoDefault() {
            JogoDefault j = new JogoDefault();
            try {
                java.lang.reflect.Field f;

                f = JogoDefault.class.getDeclaredField("id");
                f.setAccessible(true);
                f.setInt(j, id);

                f = JogoDefault.class.getDeclaredField("titulo");
                f.setAccessible(true);
                f.set(j, titulo);

                f = JogoDefault.class.getDeclaredField("descricao");
                f.setAccessible(true);
                f.set(j, descricao);

                f = JogoDefault.class.getDeclaredField("imagem");
                f.setAccessible(true);
                f.set(j, imagem);

                f = JogoDefault.class.getDeclaredField("dificuldade");
                f.setAccessible(true);
                f.set(j, dificuldade);

                f = JogoDefault.class.getDeclaredField("categorias");
                f.setAccessible(true);
                f.set(j, categorias);

            } catch (NoSuchFieldException | IllegalAccessException e) {
                throw new RuntimeException(e);
            }
            return j;
        }
    }

    // Verifica conexão
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
