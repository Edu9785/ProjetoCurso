package pt.ipleiria.estg.dei.amsi.listeners;

import java.util.ArrayList;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;

public interface JogosListener {
    void onRefreshListaJogos(ArrayList<JogoDefault> jogos);
}