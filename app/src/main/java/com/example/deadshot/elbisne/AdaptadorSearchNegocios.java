package com.example.deadshot.elbisne;

import android.content.Context;
import android.content.Intent;
import android.graphics.Paint;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.signature.StringSignature;

import java.util.List;

/**
 * Created by DEADSHOT on 20/03/2018.
 */

public class AdaptadorSearchNegocios extends RecyclerView.Adapter<AdaptadorSearchNegocios.NegocioViewHolder> {

    private List<SearchNegocio> negocios;
    Context context;
    Button btnDetalesSearchNegocio;

    public AdaptadorSearchNegocios(List<SearchNegocio> negocios){
        this.negocios = negocios;
    }

    @Override
    public NegocioViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.listado_search_negocios,parent,false);
        btnDetalesSearchNegocio = (Button)view.findViewById(R.id.btnDetalesSearchNegocio);
        return new NegocioViewHolder(view,btnDetalesSearchNegocio);
    }

    @Override
    public void onBindViewHolder(NegocioViewHolder negocioViewHolder, int position) {
        SearchNegocio negocio = negocios.get(position);

        negocioViewHolder.IdNegocio.setText(negocio.getIdNegocio());
        negocioViewHolder.NombreNegocio.setText(negocio.getNombreNegocio());
        negocioViewHolder.Descripcion.setText(negocio.getDescripcion());
        Glide.with(this.context)
                .load(negocio.getUrlImagen())
                .skipMemoryCache(true)
                .override(200,200)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                .into(negocioViewHolder.UrlImagen);
    }

    @Override
    public int getItemCount() {
        return negocios.size();
    }

    public class NegocioViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener{

        private TextView IdNegocio;
        private TextView NombreNegocio;
        private TextView Descripcion;
        private ImageView UrlImagen;

        public NegocioViewHolder(View itemView, Button button){
            super(itemView);
            itemView.setOnClickListener(this);
            context = itemView.getContext();

            context = itemView.getContext();
            IdNegocio = (TextView)itemView.findViewById(R.id.lblIdNegocio);
            NombreNegocio = (TextView)itemView.findViewById(R.id.lblNombreNegocio);
            Descripcion = (TextView)itemView.findViewById(R.id.lblDescripcion);
            UrlImagen = (ImageView) itemView.findViewById(R.id.urlImagen);
            btnDetalesSearchNegocio = (Button)itemView.findViewById(R.id.btnDetalesSearchNegocio);
            btnDetalesSearchNegocio.setPaintFlags(btnDetalesSearchNegocio.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
            btnDetalesSearchNegocio.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    MainActivity.probabilidad++;
                    Intent i =new Intent(context, ActivityDetallesAnuncio.class);
                    i.putExtra("IdAnuncio", IdNegocio.getText());
                    //context.overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
                    context.startActivity(i);
                }
            });
        }

        @Override
        public void onClick(View v) {
            MainActivity.probabilidad++;
            Intent i =new Intent(context, ActivityDetallesAnuncio.class);
            i.putExtra("IdAnuncio", IdNegocio.getText());
            //context.overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
            context.startActivity(i);
        }
    }
}
