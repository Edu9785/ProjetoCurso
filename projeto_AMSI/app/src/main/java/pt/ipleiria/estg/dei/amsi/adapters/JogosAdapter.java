package pt.ipleiria.estg.dei.amsi.adapters;

import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.FragmentActivity;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;

import java.util.List;

import pt.ipleiria.estg.dei.amsi.JogoDetalhesFragment;
import pt.ipleiria.estg.dei.amsi.JogoJogarActivity;
import pt.ipleiria.estg.dei.amsi.MainActivity;
import pt.ipleiria.estg.dei.amsi.R;
import pt.ipleiria.estg.dei.amsi.api.models.JogoDefault;

public class JogosAdapter extends RecyclerView.Adapter<JogosAdapter.ViewHolder> {

    private final List<JogoDefault> jogos;
    private final OnJogoClickListener listener;

    public interface OnJogoClickListener {
        void onDetalhes(JogoDefault jogo);

        void onJogar(JogoDefault jogo);
    }

    public JogosAdapter(List<JogoDefault> jogos, OnJogoClickListener listener) {
        this.jogos = jogos;
        this.listener = listener;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_jogo, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        JogoDefault jogo = jogos.get(position);

        holder.txtNome.setText(jogo.getTitulo());

        if (jogo.getImagem() != null && !jogo.getImagem().isEmpty()) {
            String imageUrl = "http://10.0.2.2/ProjetoCurso/projeto_PSI/frontend/web/uploads/" + jogo.getImagem();
            Glide.with(holder.itemView.getContext())
                    .load(imageUrl)
                    .placeholder(R.drawable.verde)
                    .error(R.drawable.verde)
                    .into(holder.imgJogo);
        } else {
            holder.imgJogo.setImageResource(R.drawable.verde);
        }

        // Botão Detalhes
        holder.btnDetalhes.setOnClickListener(v -> {
            JogoDetalhesFragment fragment = JogoDetalhesFragment.newInstance(jogo.getId());
            FragmentActivity activity = (FragmentActivity) holder.itemView.getContext();
            activity.getSupportFragmentManager()
                    .beginTransaction()
                    .replace(R.id.homeFragmentContainer, fragment)
                    .addToBackStack(null)
                    .commit();
        });

        // Botão Jogar → abre JogoJogarActivity
        holder.btnIniciar.setOnClickListener(v -> {
            Intent intent = new Intent(holder.itemView.getContext(), JogoJogarActivity.class);
            intent.putExtra("id_jogo", jogo.getId());
            holder.itemView.getContext().startActivity(intent);
        });
    }


    @Override
    public int getItemCount() {
        return jogos.size();
    }

    static class ViewHolder extends RecyclerView.ViewHolder {
        ImageView imgJogo;
        TextView txtNome;
        TextView btnIniciar;
        TextView btnDetalhes;

        ViewHolder(View itemView) {
            super(itemView);
            imgJogo = itemView.findViewById(R.id.imgJogo);
            txtNome = itemView.findViewById(R.id.txtNomeJogo);
            btnIniciar = itemView.findViewById(R.id.btnIniciar);
            btnDetalhes = itemView.findViewById(R.id.btnDetalhes);
        }
    }
}
