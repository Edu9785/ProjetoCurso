package pt.ipleiria.estg.dei.amsi.api;

import android.content.Context;
import android.content.SharedPreferences;

public class ApiConfig {

    private static final String PREF_API = "api_config";
    private static final String KEY_BASE_URL = "base_url";

    // valor default (localhost)
    private static final String DEFAULT_URL =
            "http://172.22.21.224/ProjetoCurso/projeto_PSI/backend/web/api/";

    public static String getBaseUrl(Context context) {
        SharedPreferences sp =
                context.getSharedPreferences(PREF_API, Context.MODE_PRIVATE);

        return sp.getString(KEY_BASE_URL, DEFAULT_URL);
    }

    public static void setBaseUrl(Context context, String url) {
        SharedPreferences sp =
                context.getSharedPreferences(PREF_API, Context.MODE_PRIVATE);

        sp.edit().putString(KEY_BASE_URL, url).apply();
    }
}