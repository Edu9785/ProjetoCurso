package pt.ipleiria.estg.dei.amsi.api;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.amsi.api.models.Categoria;
import pt.ipleiria.estg.dei.amsi.api.models.Dificuldade;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.api.models.Pergunta;
import pt.ipleiria.estg.dei.amsi.api.models.Resposta;

public class DBHelper extends SQLiteOpenHelper {

    private static final String DB_NAME = "amsi_offline.db";
    private static final int DB_VERSION = 2; // aumentei para atualizar DB

    // =========================
    // TABELA JOGOS
    // =========================
    public static final String TABLE_JOGOS = "jogosdefault";
    public static final String JOGO_ID = "id";
    public static final String JOGO_TITULO = "titulo";
    public static final String JOGO_DESCRICAO = "descricao";
    public static final String JOGO_DIFICULDADE = "id_dificuldade";
    public static final String JOGO_TEMPO = "tempo";
    public static final String JOGO_TOTALPONTOS = "totalpontosjogo";
    public static final String JOGO_IMAGEM = "imagem";

    // =========================
    // TABELA PERGUNTAS
    // =========================
    public static final String TABLE_PERGUNTAS = "pergunta";
    public static final String PERGUNTA_ID = "id";
    public static final String PERGUNTA_TEXTO = "pergunta";
    public static final String PERGUNTA_VALOR = "valor";
    public static final String PERGUNTA_JOGO_ID = "id_jogo";

    // =========================
    // TABELA RESPOSTAS
    // =========================
    public static final String TABLE_RESPOSTAS = "resposta";
    public static final String RESPOSTA_ID = "id";
    public static final String RESPOSTA_TEXTO = "resposta";
    public static final String RESPOSTA_CORRETA = "correta";
    public static final String RESPOSTA_PERGUNTA_ID = "id_pergunta";

    // =========================
    // TABELA DIFICULDADES
    // =========================
    public static final String TABLE_DIFICULDADES = "dificuldade";
    public static final String DIFICULDADE_ID = "id";
    public static final String DIFICULDADE_NOME = "dificuldade";

    // =========================
    // TABELA CATEGORIAS
    // =========================
    public static final String TABLE_CATEGORIAS = "categoria";
    public static final String CATEGORIA_ID = "id";
    public static final String CATEGORIA_NOME = "categoria";

    // =========================
    // TABELA RELACIONAMENTO JOGO-CATEGORIA
    // =========================
    public static final String TABLE_JOGO_CATEGORIA = "jogo_categoria";
    public static final String JC_JOGO_ID = "id_jogo";
    public static final String JC_CATEGORIA_ID = "id_categoria";

    // =========================
    // CREATE TABLES
    // =========================
    private static final String CREATE_JOGOS =
            "CREATE TABLE IF NOT EXISTS " + TABLE_JOGOS + " (" +
                    JOGO_ID + " INTEGER PRIMARY KEY, " +
                    JOGO_TITULO + " TEXT, " +
                    JOGO_DESCRICAO + " TEXT, " +
                    JOGO_DIFICULDADE + " INTEGER, " +
                    JOGO_TOTALPONTOS + " INTEGER, " +
                    JOGO_TEMPO + " INTEGER, " +
                    JOGO_IMAGEM + " TEXT);";

    private static final String CREATE_PERGUNTAS =
            "CREATE TABLE IF NOT EXISTS " + TABLE_PERGUNTAS + " (" +
                    PERGUNTA_ID + " INTEGER PRIMARY KEY, " +
                    PERGUNTA_TEXTO + " TEXT, " +
                    PERGUNTA_VALOR + " INTEGER, " +
                    PERGUNTA_JOGO_ID + " INTEGER);";

    private static final String CREATE_RESPOSTAS =
            "CREATE TABLE IF NOT EXISTS " + TABLE_RESPOSTAS + " (" +
                    RESPOSTA_ID + " INTEGER PRIMARY KEY, " +
                    RESPOSTA_TEXTO + " TEXT, " +
                    RESPOSTA_CORRETA + " INTEGER, " +
                    RESPOSTA_PERGUNTA_ID + " INTEGER);";

    private static final String CREATE_DIFICULDADES =
            "CREATE TABLE IF NOT EXISTS " + TABLE_DIFICULDADES + " (" +
                    DIFICULDADE_ID + " INTEGER PRIMARY KEY, " +
                    DIFICULDADE_NOME + " TEXT);";

    private static final String CREATE_CATEGORIAS =
            "CREATE TABLE IF NOT EXISTS " + TABLE_CATEGORIAS + " (" +
                    CATEGORIA_ID + " INTEGER PRIMARY KEY, " +
                    CATEGORIA_NOME + " TEXT);";

    private static final String CREATE_JOGO_CATEGORIA =
            "CREATE TABLE IF NOT EXISTS " + TABLE_JOGO_CATEGORIA + " (" +
                    JC_JOGO_ID + " INTEGER, " +
                    JC_CATEGORIA_ID + " INTEGER);";

    public DBHelper(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_JOGOS);
        db.execSQL(CREATE_PERGUNTAS);
        db.execSQL(CREATE_RESPOSTAS);
        db.execSQL(CREATE_DIFICULDADES);
        db.execSQL(CREATE_CATEGORIAS);
        db.execSQL(CREATE_JOGO_CATEGORIA);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_JOGO_CATEGORIA);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_CATEGORIAS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_DIFICULDADES);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_RESPOSTAS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_PERGUNTAS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_JOGOS);
        onCreate(db);
    }

    // ======================================================
    // OFFLINE – INSERÇÕES
    // ======================================================

    public boolean jogoExiste(int jogoId) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery(
                "SELECT 1 FROM " + TABLE_JOGOS + " WHERE " + JOGO_ID + "=?",
                new String[]{String.valueOf(jogoId)}
        );
        boolean existe = c.moveToFirst();
        c.close();
        return existe;
    }

    public void inserirJogo(JogoDefault jogo) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues cv = new ContentValues();
        cv.put(JOGO_ID, jogo.getId());
        cv.put(JOGO_TITULO, jogo.getTitulo());
        cv.put(JOGO_DESCRICAO, jogo.getDescricao());
        cv.put(JOGO_DIFICULDADE, jogo.getDificuldade().getId());
        cv.put(JOGO_TOTALPONTOS, jogo.getTotalpontosjogo());
        cv.put(JOGO_IMAGEM, jogo.getImagem());
        db.insertWithOnConflict(TABLE_JOGOS, null, cv, SQLiteDatabase.CONFLICT_REPLACE);
    }

    public boolean perguntaExiste(int perguntaId) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery(
                "SELECT 1 FROM " + TABLE_PERGUNTAS + " WHERE " + PERGUNTA_ID + "=?",
                new String[]{String.valueOf(perguntaId)}
        );
        boolean existe = c.moveToFirst();
        c.close();
        return existe;
    }

    public void inserirPergunta(Pergunta p, int jogoId) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues cv = new ContentValues();
        cv.put(PERGUNTA_ID, p.getId());
        cv.put(PERGUNTA_TEXTO, p.getPergunta());
        cv.put(PERGUNTA_VALOR, p.getValor());
        cv.put(PERGUNTA_JOGO_ID, jogoId);
        db.insertWithOnConflict(TABLE_PERGUNTAS, null, cv, SQLiteDatabase.CONFLICT_REPLACE);
    }

    public boolean respostaExiste(int respostaId) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery(
                "SELECT 1 FROM " + TABLE_RESPOSTAS + " WHERE " + RESPOSTA_ID + "=?",
                new String[]{String.valueOf(respostaId)}
        );
        boolean existe = c.moveToFirst();
        c.close();
        return existe;
    }

    public void inserirResposta(Resposta r, int perguntaId) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues cv = new ContentValues();
        cv.put(RESPOSTA_ID, r.getId());
        cv.put(RESPOSTA_TEXTO, r.getResposta());
        cv.put(RESPOSTA_CORRETA, r.isCorreta() ? 1 : 0);
        cv.put(RESPOSTA_PERGUNTA_ID, perguntaId);
        db.insertWithOnConflict(TABLE_RESPOSTAS, null, cv, SQLiteDatabase.CONFLICT_REPLACE);
    }

    // =========================
    // DIFICULDADES / CATEGORIAS
    // =========================
    public void inserirCategoria(Categoria c) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues cv = new ContentValues();
        cv.put(CATEGORIA_ID, c.getId());
        cv.put(CATEGORIA_NOME, c.getCategoria());
        db.insert(TABLE_CATEGORIAS, null, cv);
    }

    public ArrayList<Categoria> mostrarCategorias() {
        ArrayList<Categoria> lista = new ArrayList<>();
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery("SELECT * FROM " + TABLE_CATEGORIAS, null);
        while (c.moveToNext()) {
            Categoria cat = new Categoria();
            cat.setId(c.getInt(c.getColumnIndexOrThrow(CATEGORIA_ID)));
            cat.setCategoria(c.getString(c.getColumnIndexOrThrow(CATEGORIA_NOME)));
            lista.add(cat);
        }
        c.close();
        return lista;
    }

    public void inserirDificuldade(Dificuldade d) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues cv = new ContentValues();
        cv.put(DIFICULDADE_ID, d.getId());
        cv.put(DIFICULDADE_NOME, d.getDificuldade());
        db.insert(TABLE_DIFICULDADES, null, cv);
    }

    public ArrayList<Dificuldade> mostrarDificuldades() {
        ArrayList<Dificuldade> lista = new ArrayList<>();
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery("SELECT * FROM " + TABLE_DIFICULDADES, null);
        while (c.moveToNext()) {
            Dificuldade d = new Dificuldade();
            d.setId(c.getInt(c.getColumnIndexOrThrow(DIFICULDADE_ID)));
            d.setDificuldade(c.getString(c.getColumnIndexOrThrow(DIFICULDADE_NOME)));
            lista.add(d);
        }
        c.close();
        return lista;
    }


    public void inserirJogoCategoria(int jogoId, int categoriaId) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues cv = new ContentValues();
        cv.put(JC_JOGO_ID, jogoId);
        cv.put(JC_CATEGORIA_ID, categoriaId);
        db.insertWithOnConflict(TABLE_JOGO_CATEGORIA, null, cv, SQLiteDatabase.CONFLICT_REPLACE);
    }

    // =========================
    // CONSULTAS OFFLINE
    // =========================
    public ArrayList<JogoDefault> mostrarJogos() {
        ArrayList<JogoDefault> jogos = new ArrayList<>();
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery("SELECT * FROM " + TABLE_JOGOS, null);

        while (c.moveToNext()) {
            JogoDefault j = new JogoDefault();
            j.setId(c.getInt(c.getColumnIndexOrThrow(JOGO_ID)));
            j.setTitulo(c.getString(c.getColumnIndexOrThrow(JOGO_TITULO)));
            j.setDescricao(c.getString(c.getColumnIndexOrThrow(JOGO_DESCRICAO)));
            j.setImagem(c.getString(c.getColumnIndexOrThrow(JOGO_IMAGEM)));
            j.setTotalpontosjogo(c.getInt(c.getColumnIndexOrThrow(JOGO_TOTALPONTOS)));

            // Carregar dificuldade
            int idDif = c.getInt(c.getColumnIndexOrThrow(JOGO_DIFICULDADE));
            j.setDificuldade(verDificuldade(idDif));

            // Carregar categorias
            j.setCategorias(verCategoriasJogo(j.getId()));

            jogos.add(j);
        }
        c.close();
        return jogos;
    }

    public JogoDefault verJogo(int jogoId) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery("SELECT * FROM " + TABLE_JOGOS + " WHERE " + JOGO_ID + "=?",
                new String[]{String.valueOf(jogoId)});

        if (c.moveToFirst()) {
            JogoDefault j = new JogoDefault();
            j.setId(c.getInt(c.getColumnIndexOrThrow(JOGO_ID)));
            j.setTitulo(c.getString(c.getColumnIndexOrThrow(JOGO_TITULO)));
            j.setDescricao(c.getString(c.getColumnIndexOrThrow(JOGO_DESCRICAO)));
            j.setTotalpontosjogo(c.getInt(c.getColumnIndexOrThrow(JOGO_TOTALPONTOS)));
            j.setImagem(c.getString(c.getColumnIndexOrThrow(JOGO_IMAGEM)));

            // Dificuldade
            int idDif = c.getInt(c.getColumnIndexOrThrow(JOGO_DIFICULDADE));
            j.setDificuldade(verDificuldade(idDif));

            // Categorias
            j.setCategorias(verCategoriasJogo(j.getId()));

            c.close();
            return j;
        }
        c.close();
        return null;
    }

    public Dificuldade verDificuldade(int idDificuldade) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery("SELECT * FROM " + TABLE_DIFICULDADES + " WHERE " + DIFICULDADE_ID + "=?",
                new String[]{String.valueOf(idDificuldade)});
        if (c.moveToFirst()) {
            Dificuldade d = new Dificuldade();
            d.setId(c.getInt(c.getColumnIndexOrThrow(DIFICULDADE_ID)));
            d.setDificuldade(c.getString(c.getColumnIndexOrThrow(DIFICULDADE_NOME)));
            c.close();
            return d;
        }
        c.close();
        return null;
    }

    public ArrayList<Categoria> verCategoriasJogo(int jogoId) {
        ArrayList<Categoria> categorias = new ArrayList<>();
        SQLiteDatabase db = getReadableDatabase();
        Cursor c = db.rawQuery(
                "SELECT cat.id, cat.categoria FROM " + TABLE_CATEGORIAS + " cat " +
                        "INNER JOIN " + TABLE_JOGO_CATEGORIA + " jc ON cat.id = jc.id_categoria " +
                        "WHERE jc.id_jogo = ?",
                new String[]{String.valueOf(jogoId)}
        );

        while (c.moveToNext()) {
            Categoria cat = new Categoria();
            cat.setId(c.getInt(c.getColumnIndexOrThrow(CATEGORIA_ID)));
            cat.setCategoria(c.getString(c.getColumnIndexOrThrow(CATEGORIA_NOME)));
            categorias.add(cat);
        }
        c.close();
        return categorias;
    }

    // Perguntas e respostas continuam iguais
    public ArrayList<Pergunta> jogarJogo(int jogoId) {
        ArrayList<Pergunta> perguntas = new ArrayList<>();
        SQLiteDatabase db = getReadableDatabase();

        Cursor pCur = db.rawQuery("SELECT * FROM " + TABLE_PERGUNTAS + " WHERE " + PERGUNTA_JOGO_ID + "=?",
                new String[]{String.valueOf(jogoId)});

        while (pCur.moveToNext()) {
            Pergunta p = new Pergunta(
                    pCur.getInt(pCur.getColumnIndexOrThrow(PERGUNTA_ID)),
                    pCur.getString(pCur.getColumnIndexOrThrow(PERGUNTA_TEXTO)),
                    pCur.getInt(pCur.getColumnIndexOrThrow(PERGUNTA_VALOR))
            );

            Cursor rCur = db.rawQuery("SELECT * FROM " + TABLE_RESPOSTAS + " WHERE " + RESPOSTA_PERGUNTA_ID + "=?",
                    new String[]{String.valueOf(p.getId())});

            while (rCur.moveToNext()) {
                Resposta r = new Resposta(
                        rCur.getInt(rCur.getColumnIndexOrThrow(RESPOSTA_ID)),
                        rCur.getString(rCur.getColumnIndexOrThrow(RESPOSTA_TEXTO)),
                        rCur.getInt(rCur.getColumnIndexOrThrow(RESPOSTA_CORRETA)) == 1
                );
                p.addResposta(r);
            }
            rCur.close();
            perguntas.add(p);
        }
        pCur.close();
        return perguntas;
    }
}
