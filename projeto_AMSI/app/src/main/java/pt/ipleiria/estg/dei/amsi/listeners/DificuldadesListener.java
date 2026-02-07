package pt.ipleiria.estg.dei.amsi.listeners;

import java.util.ArrayList;
import pt.ipleiria.estg.dei.amsi.api.models.Dificuldade;

public interface DificuldadesListener {
    void onRefreshDificuldades(ArrayList<Dificuldade> dificuldades);
}
