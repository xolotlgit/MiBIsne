package com.example.deadshot.elbisne;

import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.support.v4.graphics.drawable.RoundedBitmapDrawable;
import android.support.v4.graphics.drawable.RoundedBitmapDrawableFactory;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.Transformation;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.load.engine.Resource;
import com.bumptech.glide.load.resource.bitmap.CenterCrop;
import com.bumptech.glide.request.target.BitmapImageViewTarget;
import com.bumptech.glide.signature.StringSignature;

import java.util.List;

import de.hdodenhof.circleimageview.CircleImageView;

/**
 * Created by DEADSHOT on 09/03/2018.
 */

public class AdaptadorUserNegocios extends RecyclerView.Adapter<AdaptadorUserNegocios.UserNegocioViewHolder>{

    private List<UserNegocio> negocios;
    Context context;
    Button btnDetallesNegocio;

    public AdaptadorUserNegocios(List<UserNegocio> negocios ){
        this.negocios = negocios;
    }

    @Override
    public AdaptadorUserNegocios.UserNegocioViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.listado_negocios,parent,false);
        btnDetallesNegocio = (Button)view.findViewById(R.id.btnDetallesNegocio);
        return new UserNegocioViewHolder(view, btnDetallesNegocio);
    }


    @Override
    public void onBindViewHolder(final AdaptadorUserNegocios.UserNegocioViewHolder userNegocioViewHolder, int position) {
        UserNegocio userNegocio = negocios.get(position);
        userNegocioViewHolder.IdNegocio.setText(userNegocio.getIdNegocio());
        userNegocioViewHolder.NombreNegocio.setText(userNegocio.getNombreNegocio());
        userNegocioViewHolder.DescripcionNegocio.setText(userNegocio.getDescripcionNegocio());
        userNegocioViewHolder.FechaIni.setText(userNegocio.getFechaIni());
        userNegocioViewHolder.FechaFin.setText(userNegocio.getFechaFin());
        Glide.with(this.context)
                .load(userNegocio.getImgUrl())
                .asBitmap().placeholder(R.drawable.tiendaabarrotes)
                .centerCrop()
                .override(200,200)
                .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                .skipMemoryCache(true)
                .diskCacheStrategy(DiskCacheStrategy.ALL)
                .animate(android.R.anim.fade_in)
                .into(new BitmapImageViewTarget(userNegocioViewHolder.ImgUrl) {
                    @Override
                    protected void setResource(Bitmap resource) {
                        RoundedBitmapDrawable circularBitmapDrawable =
                                RoundedBitmapDrawableFactory.create(context.getResources(), resource);
                        circularBitmapDrawable.setCircular(true);
                        userNegocioViewHolder.ImgUrl.setImageDrawable(circularBitmapDrawable);
                    }
                });

    }

    @Override
    public int getItemCount() {
        return negocios.size();
    }

    public class UserNegocioViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        private TextView IdNegocio;
        private  TextView NombreNegocio;
        private  TextView DescripcionNegocio;
        private  TextView FechaIni;
        private  TextView FechaFin;
        private ImageView ImgUrl;

        public  UserNegocioViewHolder(View itemView, Button button){
            super(itemView);
            itemView.setOnClickListener(this);
            context = itemView.getContext();

            IdNegocio = (TextView)itemView.findViewById(R.id.txtIdNegocio);
            IdNegocio.setVisibility(View.GONE);
            NombreNegocio = (TextView)itemView.findViewById(R.id.txtNombreNegocio);
            DescripcionNegocio = (TextView)itemView.findViewById(R.id.txtDescripcionNegocio);
            FechaIni = (TextView)itemView.findViewById(R.id.txtFechInicio);
            FechaFin = (TextView)itemView.findViewById(R.id.txtFechFin);
            ImgUrl = (ImageView)itemView.findViewById(R.id.ImgNegocio);
            btnDetallesNegocio = (Button)itemView.findViewById(R.id.btnDetallesNegocio);
            btnDetallesNegocio.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent i =new Intent(context, ActivityDetallesNegocio.class);
                    i.putExtra("IdNegocio", IdNegocio.getText());
                    //context.overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
                    context.startActivity(i);
                }
            });
        }

        @Override
        public void onClick(View view) {
            Intent i =new Intent(context, ActivityDetallesNegocio.class);
            i.putExtra("IdNegocio", IdNegocio.getText());
            //context.overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
            context.startActivity(i);
        }
    }
}
