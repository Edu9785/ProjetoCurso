package pt.ipleiria.estg.dei.amsi.listeners;

import java.util.ArrayList;
import pt.ipleiria.estg.dei.amsi.api.models.Categoria;

public interface CategoriasListener {
    void onRefreshCategorias(ArrayList<Categoria> categorias);
}
