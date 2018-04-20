package com.example.deadshot.elbisne;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.support.design.widget.TextInputEditText;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Toast;

import java.util.List;

/**
 * Created by DEADSHOT on 01/03/2018.
 */

public class AdaptadorContactos extends RecyclerView.Adapter<AdaptadorContactos.ContactoViewHolder> {

    private List<Contacto> contactos;
    Context context;

    public AdaptadorContactos(List<Contacto> contactos){
        this.contactos = contactos;
    }


    @Override
    public ContactoViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.list_contactos,parent,false);

        return new ContactoViewHolder(view);
    }

    @Override
    public void onBindViewHolder(ContactoViewHolder contactoViewHolder, int position) {
        Contacto contacto = contactos.get(position);
        contactoViewHolder.NombreC.setText(contacto.getNombreContacto());
        contactoViewHolder.TelefonoC.setText(contacto.getTelefonoContacto());
        contactoViewHolder.CorreoC.setText(contacto.getCorreoContacto());

    }

    @Override
    public int getItemCount() {
        return contactos.size();
    }

    public class ContactoViewHolder extends RecyclerView.ViewHolder{
        private TextInputEditText NombreC;
        private TextInputEditText TelefonoC;
        private TextInputEditText CorreoC;
        private Button btnLlamarTelCon,btnMensajeTelCon,btnCorreoCon;

        public ContactoViewHolder(View itemView){
            super(itemView);
            context = itemView.getContext();

            NombreC = (TextInputEditText)itemView.findViewById(R.id.txtNombreContacto);
            TelefonoC = (TextInputEditText)itemView.findViewById(R.id.txtTel1Contacto);
            CorreoC = (TextInputEditText)itemView.findViewById(R.id.txtCorreoContacto);
            btnLlamarTelCon = (Button)itemView.findViewById(R.id.btnLlamarTelCon);
            btnMensajeTelCon = (Button)itemView.findViewById(R.id.btnMensajeTelCon);
            btnCorreoCon = (Button)itemView.findViewById(R.id.btnCorreoCon);

            btnLlamarTelCon.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    String number = TelefonoC.getText().toString();
                    Uri call = Uri.parse("tel:" + number);
                    Intent surf = new Intent(Intent.ACTION_DIAL, call);
                    context.startActivity(surf);
                }
            });
            btnMensajeTelCon.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    String message = "[Mensaje enviado desde 'Mi Bisne']";
                    String phoneNo = TelefonoC.getText().toString();
                    Intent smsIntent = new Intent(Intent.ACTION_SENDTO, Uri.parse("smsto:" + phoneNo));
                    smsIntent.putExtra("sms_body", message);
                    context.startActivity(smsIntent);
                }
            });
            btnCorreoCon.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Intent emailIntent = new Intent(Intent.ACTION_SENDTO, Uri.fromParts("mailto",CorreoC.getText().toString(), null));
                    emailIntent.putExtra(Intent.EXTRA_SUBJECT, "Correo Enviado desde 'Mi Bisne' ");
                    context.startActivity(Intent.createChooser(emailIntent, "Enviar email."));
                }
            });
        }
    }
}
