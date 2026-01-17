package pt.ipleiria.estg.dei.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.amsi.adapters.JogosAdapter;
import pt.ipleiria.estg.dei.amsi.api.SingletonAPI;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;
import pt.ipleiria.estg.dei.amsi.listeners.JogosListener;

public class JogosFragment extends Fragment implements JogosListener {

    private RecyclerView recyclerJogos;

    @Override
    public View onCreateView(
            @NonNull LayoutInflater inflater,
            ViewGroup container,
            Bundle savedInstanceState
    ) {
        View view = inflater.inflate(R.layout.fragment_jogos, container, false);

        recyclerJogos = view.findViewById(R.id.recyclerJogos);
        recyclerJogos.setLayoutManager(new GridLayoutManager(getContext(), 2));

        SingletonAPI.getInstance(requireContext()).setJogosListener(this);
        SingletonAPI.getInstance(requireContext()).getJogosAPI(requireContext());

        return view;
    }

    @Override
    public void onRefreshListaJogos(ArrayList<JogoDefault> jogos) {

        recyclerJogos.setAdapter(new JogosAdapter(jogos, new JogosAdapter.OnJogoClickListener() {
            @Override
            public void onDetalhes(JogoDefault jogo) {
                Bundle b = new Bundle();
                b.putInt("jogo_id", jogo.getId());

                JogoDetalhesFragment fragment = new JogoDetalhesFragment();
                fragment.setArguments(b);

                requireActivity().getSupportFragmentManager()
                        .beginTransaction()
                        .replace(R.id.homeFragmentContainer, fragment)
                        .addToBackStack(null)
                        .commit();
            }

            @Override
            public void onJogar(JogoDefault jogo) {
                Intent i = new Intent(getContext(), JogoJogarActivity.class);
                i.putExtra("jogo_id", jogo.getId());
                startActivity(i);
            }
        }));
    }
}
