package pt.ipleiria.estg.dei.amsi.listeners;

import pt.ipleiria.estg.dei.amsi.api.models.Jogador;

public interface ProfileListener {
    void onLoadProfile(Jogador jogador);
}