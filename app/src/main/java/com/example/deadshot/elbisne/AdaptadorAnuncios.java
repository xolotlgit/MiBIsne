package com.example.deadshot.elbisne;


import android.content.Context;
import android.content.Intent;
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
 * Created by DEADSHOT on 06/03/2018.
 */

public class AdaptadorAnuncios extends RecyclerView.Adapter<AdaptadorAnuncios.AnuncioViewHolder>{

    private List<Anuncio> anuncios;
    Context context;
    Button btnDetalesAnuncio;

    public AdaptadorAnuncios(List<Anuncio> anuncios ){
        this.anuncios = anuncios;
    }

    @Override
    public AnuncioViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.listado_anuncios,parent,false);
        btnDetalesAnuncio = (Button)view.findViewById(R.id.btnDetalesAnuncio);
        return new AnuncioViewHolder(view, btnDetalesAnuncio);
    }


    @Override
    public void onBindViewHolder(AnuncioViewHolder anuncioViewHolder, int position) {
        Anuncio anuncio = anuncios.get(position);
        anuncioViewHolder.IdNego.setText(anuncio.getIdNego());
        anuncioViewHolder.NobreAnuncio.setText(anuncio.getNobreAnuncio());
        anuncioViewHolder.FechaInicio.setText(anuncio.getFechaInicio());
        anuncioViewHolder.FechaFin.setText(anuncio.getFechaFin());
        Glide.with(this.context)
                .load(anuncio.getImgUrl())
                .thumbnail(Glide.with(this.context).load(R.drawable.tiendaabarrotes).centerCrop())
                .skipMemoryCache(true)
                .override(200,200)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                .into(anuncioViewHolder.ImgUrl);
    }

    @Override
    public int getItemCount() {
        return anuncios.size();
    }

    public class AnuncioViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        private  TextView IdNego;
        private  TextView NobreAnuncio;
        private  TextView FechaInicio;
        private  TextView FechaFin;
        private ImageView ImgUrl;

        public  AnuncioViewHolder(View itemView, Button button){
            super(itemView);
            itemView.setOnClickListener(this);
            context = itemView.getContext();

            IdNego = (TextView)itemView.findViewById(R.id.txtIdNegoAnuncio);
            NobreAnuncio = (TextView)itemView.findViewById(R.id.txtNombreAnuncio);
            FechaInicio = (TextView)itemView.findViewById(R.id.txtFechaInicioAnuncio);
            FechaFin = (TextView)itemView.findViewById(R.id.txtFechaFinAnuncio);
            ImgUrl = (ImageView)itemView.findViewById(R.id.imgUrlAnuncio);
            btnDetalesAnuncio = (Button)itemView.findViewById(R.id.btnDetalesAnuncio);
            btnDetalesAnuncio.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    MainActivity.probabilidad++;
                    Intent i =new Intent(context, ActivityDetallesAnuncio.class);
                    i.putExtra("IdAnuncio", IdNego.getText());
                    //context.overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
                    context.startActivity(i);
                }
            });
        }

        @Override
        public void onClick(View view) {
            MainActivity.probabilidad++;
            Intent i =new Intent(context, ActivityDetallesAnuncio.class);
            i.putExtra("IdAnuncio", IdNego.getText());
            //context.overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
            context.startActivity(i);
        }
    }
}