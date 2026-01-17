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

    // ======================
    // LOGIN
    // ======================
    public static String parseLoginToken(String response) {
        try {
            return new JSONObject(response).getString("token");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    public static int parseLoginId(String response) {
        try {
            return new JSONObject(response).getInt("jogador_id");
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    // ======================
    // JOGADOR
    // ======================
    public static Jogador parseJogador(String response) {
        try {
            JSONObject json = new JSONObject(response);

            return new JogadorWrapper(
                    json.getInt("id"),
                    json.optString("nome"),
                    json.optInt("idade"),
                    json.optInt("id_premium"),
                    json.optString("username"),
                    json.optString("email")
            ).toJogador();

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
    }

    // ======================
    // JOGOS
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

                // TOTAL DE PONTOS
                int totalPontos = jsonJogo.optInt("totalpontosjogo", 0);

                // ---------- DIFICULDADE ----------
                Dificuldade dificuldade = null;
                if (jsonJogo.has("dificuldade") && !jsonJogo.isNull("dificuldade")) {

                    JSONObject d = jsonJogo.getJSONObject("dificuldade");

                    dificuldade = new DificuldadeWrapper(
                            d.optInt("id", 0),
                            d.optString("nome", "Indefinida")
                    ).toDificuldade();
                }

                // ---------- CATEGORIAS ----------
                List<Categoria> categorias = new ArrayList<>();
                if (jsonJogo.has("categorias") && !jsonJogo.isNull("categorias")) {

                    JSONArray jsonCategorias = jsonJogo.getJSONArray("categorias");

                    for (int j = 0; j < jsonCategorias.length(); j++) {
                        JSONObject c = jsonCategorias.getJSONObject(j);

                        categorias.add(
                                new CategoriaWrapper(
                                        c.optInt("id", 0),
                                        c.optString("nome", "Indefinida")
                                ).toCategoria()
                        );
                    }
                }

                jogos.add(
                        new JogoDefaultWrapper(
                                id,
                                titulo,
                                descricao,
                                imagem,
                                totalPontos,
                                dificuldade,
                                categorias
                        ).toJogoDefault()
                );

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return jogos;
    }


    // ======================
    // CATEGORIAS (LISTA COMPLETA)
    // ======================
    public static ArrayList<Categoria> parseCategorias(JSONArray response) {

        ArrayList<Categoria> categorias = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject json = response.getJSONObject(i);

                categorias.add(
                        new CategoriaWrapper(
                                json.getInt("id"),
                                json.getString("categoria")
                        ).toCategoria()
                );

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return categorias;
    }


    // ======================
    // DIFICULDADES (LISTA COMPLETA)
    // ======================
    public static ArrayList<Dificuldade> parseDificuldades(JSONArray response) {

        ArrayList<Dificuldade> dificuldades = new ArrayList<>();

        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject json = response.getJSONObject(i);

                dificuldades.add(
                        new DificuldadeWrapper(
                                json.getInt("id"),
                                json.getString("dificuldade")
                        ).toDificuldade()
                );

            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }

        return dificuldades;
    }



    // ======================
    // WRAPPERS
    // ======================
    private static class JogadorWrapper {
        int id, idade, id_premium;
        String nome, username, email;

        JogadorWrapper(int id, String nome, int idade, int id_premium, String username, String email) {
            this.id = id;
            this.nome = nome;
            this.idade = idade;
            this.id_premium = id_premium;
            this.username = username;
            this.email = email;
        }

        Jogador toJogador() {
            Jogador j = new Jogador();
            try {
                set(j, "id", id);
                set(j, "nome", nome);
                set(j, "idade", idade);
                set(j, "id_premium", id_premium);
                set(j, "username", username);
                set(j, "email", email);
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            return j;
        }
    }

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
                set(d, "id", id);
                set(d, "dificuldade", dificuldade);
            } catch (Exception e) {
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
                set(c, "id", id);
                set(c, "categoria", categoria);
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            return c;
        }
    }

    private static class JogoDefaultWrapper {
        int id;
        String titulo, descricao, imagem;
        int totalpontosjogo;
        Dificuldade dificuldade;
        List<Categoria> categorias;

        JogoDefaultWrapper(int id, String titulo, String descricao, String imagem,
                           int totalpontosjogo,
                           Dificuldade dificuldade,
                           List<Categoria> categorias) {

            this.id = id;
            this.titulo = titulo;
            this.descricao = descricao;
            this.imagem = imagem;
            this.totalpontosjogo = totalpontosjogo;
            this.dificuldade = dificuldade;
            this.categorias = categorias;
        }

        JogoDefault toJogoDefault() {
            JogoDefault j = new JogoDefault();
            try {
                set(j, "id", id);
                set(j, "titulo", titulo);
                set(j, "descricao", descricao);
                set(j, "imagem", imagem);
                set(j, "totalpontosjogo", totalpontosjogo);
                set(j, "dificuldade", dificuldade);
                set(j, "categorias", categorias);
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
            return j;
        }
    }

    // ======================
    // REFLECTION HELPER
    // ======================
    private static void set(Object o, String field, Object value)
            throws NoSuchFieldException, IllegalAccessException {

        java.lang.reflect.Field f = o.getClass().getDeclaredField(field);
        f.setAccessible(true);
        f.set(o, value);
    }

    // ======================
    // INTERNET
    // ======================
    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm =
                (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }

    // ======================
// PARSE JOGO DETALHES (JSONObject -> JogoDefault)
// ======================
    public static JogoDefault parseJogoDetalhes(JSONObject jsonJogo) {
        try {
            int id = jsonJogo.getInt("id");
            String titulo = jsonJogo.optString("titulo", "");
            String descricao = jsonJogo.optString("descricao", "");
            String imagem = jsonJogo.optString("imagem", "");
            int totalPontos = jsonJogo.optInt("totalpontosjogo", 0);

            // Dificuldade
            Dificuldade dificuldade = null;
            if (jsonJogo.has("dificuldade") && !jsonJogo.isNull("dificuldade")) {
                JSONObject d = jsonJogo.getJSONObject("dificuldade");
                dificuldade = new Dificuldade();
                dificuldade.setId(d.optInt("id", 0));
                dificuldade.setDificuldade(d.optString("dificuldade", "Indefinida"));
            }

            // Categorias
            List<Categoria> categorias = new ArrayList<>();
            if (jsonJogo.has("categorias") && !jsonJogo.isNull("categorias")) {
                JSONArray catArray = jsonJogo.getJSONArray("categorias");
                for (int i = 0; i < catArray.length(); i++) {
                    JSONObject c = catArray.getJSONObject(i);
                    Categoria cat = new Categoria();
                    cat.setId(c.optInt("id", 0));
                    cat.setCategoria(c.optString("categoria", "Indefinida"));
                    categorias.add(cat);
                }
            }

            // Montar JogoDefault
            JogoDefault jogo = new JogoDefault();
            jogo.setId(id);
            jogo.setTitulo(titulo);
            jogo.setDescricao(descricao);
            jogo.setImagem(imagem);
            jogo.setTotalpontosjogo(totalPontos);
            jogo.setDificuldade(dificuldade);
            jogo.setCategorias(categorias);

            return jogo;

        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
}
