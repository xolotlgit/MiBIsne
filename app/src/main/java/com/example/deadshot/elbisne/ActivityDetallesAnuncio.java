package com.example.deadshot.elbisne;

import android.app.ActionBar;
import android.app.ProgressDialog;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.RotateAnimation;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.ViewFlipper;
import android.net.Uri;
import android.content.Intent;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.signature.StringSignature;

import org.json.JSONArray;
import org.json.JSONException;

import java.util.Hashtable;
import java.util.Map;

import android.animation.Animator;
import android.view.animation.AnimationUtils;
import android.view.animation.Interpolator;

public class ActivityDetallesAnuncio extends AppCompatActivity {

    //Id del Negocio Seleccionado
    String IdNegocio;
    //Dato para Enviar al Servidor
    private String KEY_IDNEGOCIO = "IdNegocio";
    private String KEY_IDUSUARIO = "IdUsuario";
    private String KEY_CALIFICACION = "Calificacion";
    String Calificacion;
    String Ruta = MainActivity.RutaWeb;
    //Variables dentro del layoud Activy detallesAnuncio
    TextView lblIdUsuario,lblIdNegocio,lblNombreNegocio,lblDescripcion,lblDireccion,lblHorario,lblTel_F,lblTel_M,lblEmail,lblSitioWeb,lblFacebook,lblTwitter,lblOtraRed,lblInstagram,lblStatus,lblValoracion;
    String Latitud, Longitud, PosicionGPS ="";
    ImageView imageView1,imageView2,imageView3;
    ViewFlipper viewFlipper;
    RatingBar ratingBar;
    //Witget para expand&andCollapse de los datos
    private static final int DURATION = 250;
    private ViewGroup ContenedorDetallesGeneral, ContenedorDetallesContacto, ContenedorDetallesSocial,buttosTelM,buttosTelF;
    private ImageView imageViewExpand1,imageViewExpand2,imageViewExpand3;
    int ValorActual=0;
    int contador = 0;

    Button btnLlamarTelF,btnLlamarTelM,btnMensajeTelF,btnMensajeTelM,btnVerMapa,btnCorreoElect;

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                onBackPressed();
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalles_anuncio);
        setTitle("Detalles del Negocio");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);

        final FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);

        if (MainActivity.probabilidad  == 5){
            fab.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Snackbar.make(view, "Felicidades has encontrado un Ticket.", Snackbar.LENGTH_LONG)
                            .setAction("Action", null).show();
                    MainActivity.probabilidad = 0;

                    if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.LOLLIPOP) {
                        final Interpolator interpolador = AnimationUtils.loadInterpolator(getBaseContext(),
                                android.R.interpolator.fast_out_slow_in);
                        fab.animate().scaleY(0).scaleX(0).setInterpolator(interpolador).setDuration(600).start();
                    }
                    GetTicket();
                    fab.setVisibility(View.GONE);
                }
            });
        }else {
            fab.setVisibility(View.GONE);
        }

        lblIdNegocio = (TextView)findViewById(R.id.lblIdNegocio);
        lblIdUsuario = (TextView)findViewById(R.id.lblIdUsuario);
        lblNombreNegocio = (TextView)findViewById(R.id.lblNombreNegocio);
        lblDescripcion = (TextView)findViewById(R.id.lblDescripcion);
        lblDireccion = (TextView)findViewById(R.id.lblDireccion);
        lblHorario = (TextView)findViewById(R.id.lblHorario);
        lblTel_F = (TextView)findViewById(R.id.lblTel_F);
        lblTel_M = (TextView)findViewById(R.id.lblTel_M);
        lblEmail = (TextView)findViewById(R.id.lblEmail);
        lblSitioWeb = (TextView)findViewById(R.id.lblSitioWeb);
        lblFacebook = (TextView)findViewById(R.id.lblFacebook);
        lblInstagram = (TextView)findViewById(R.id.lblInstagram);
        lblTwitter = (TextView)findViewById(R.id.lblTwitter);
        lblOtraRed= (TextView)findViewById(R.id.lblOtraRed);
        lblStatus = (TextView)findViewById(R.id.lblStatus);
        lblValoracion =(TextView)findViewById(R.id.lblValoracion);
        imageView1 = (ImageView)findViewById(R.id.imageView1);
        imageView2 = (ImageView)findViewById(R.id.imageView2);
        imageView3 = (ImageView)findViewById(R.id.imageView3);

        viewFlipper = (ViewFlipper)this.findViewById(R.id.viewFlipperImgNegocio);

        ratingBar = (RatingBar) findViewById(R.id.ratingBar);

        btnVerMapa = (Button)findViewById(R.id.btnVerMapa);
        btnMensajeTelF = (Button)findViewById(R.id.btnMensajeTelF);
        btnMensajeTelM = (Button)findViewById(R.id.btnMensajeTelM);
        btnLlamarTelF = (Button)findViewById(R.id.btnLlamarTelF);
        btnLlamarTelM = (Button)findViewById(R.id.btnLlamarTelM);
        btnCorreoElect = (Button)findViewById(R.id.btnCorreoElect);

        //Contenedores de Botones de llamado
        buttosTelM= (ViewGroup)findViewById(R.id.buttosTelM);
        buttosTelF= (ViewGroup)findViewById(R.id.buttosTelF);

        //Linerar Layout que contiene los datos(Detalles) de cada Seccion
        ContenedorDetallesGeneral = (ViewGroup)findViewById(R.id.ContenedorDetallesGeneral);
        ContenedorDetallesContacto = (ViewGroup)findViewById(R.id.ContenedorDetallesContacto);
        ContenedorDetallesSocial = (ViewGroup)findViewById(R.id.ContenedorDetallesSocial);
        //END Linerar Layout que contiene los datos(Detalles) de cada Seccion
        //Imagen de Expand para cada Seccion
        imageViewExpand1 = (ImageView)findViewById(R.id.imageViewExpand1);
        imageViewExpand2 = (ImageView)findViewById(R.id.imageViewExpand2);
        imageViewExpand3 = (ImageView)findViewById(R.id.imageViewExpand3);
        //END Imagen de Expand para cada Seccion

        //Listenr de expand Detalles

        LinearLayout btnDetallesGeneralNegocio = (LinearLayout)findViewById(R.id.btnDetallesGeneralNegocio);
        LinearLayout btnDetallesContactoNegocio = (LinearLayout)findViewById(R.id.btnDetallesContactoNegocio);
        LinearLayout btnDetallesSocialNegocio = (LinearLayout)findViewById(R.id.btnDetallesSocialNegocio);

        btnDetallesGeneralNegocio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ValorActual =1;
                DetallesDeNegocio();
            }
        });
        btnDetallesContactoNegocio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ValorActual =2;
                DetallesDeNegocio();
            }
        });
        btnDetallesSocialNegocio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ValorActual =3;
                DetallesDeNegocio();
            }
        });

        ratingBar.setOnRatingBarChangeListener(new RatingBar.OnRatingBarChangeListener() {
            public void onRatingChanged(RatingBar ratingBar, float rating,
                                        boolean fromUser) {
                if (contador > 0){
                    Calificacion = String.valueOf(rating);
                    GuardarValoracion();
                }
            }
        });

        IdNegocio ="";
        Bundle extras = getIntent().getExtras();
        if (extras != null){
            IdNegocio = extras.getString("IdAnuncio");
            //Elimina las "" de cada registro dejando solo el dato String con el IddelNegocio
            int cadena1 = IdNegocio.length();
            String extraerp = IdNegocio.substring(0,1);
            String extraeru = IdNegocio.substring(IdNegocio.length()-1);
            String remplazado=IdNegocio.replace(extraerp,"");
            IdNegocio=remplazado.replace(extraeru, "");
            CargarDatosNegocio();
            onClick();
        }else {
            Toast.makeText(ActivityDetallesAnuncio.this,"Ha ocurrido un error inténtalo más tarde",Toast.LENGTH_LONG).show();
            finish();
        }

        lblTel_F.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String number = lblTel_F.getText().toString();
                Uri call = Uri.parse("tel:" + number);
                Intent surf = new Intent(Intent.ACTION_DIAL, call);
                startActivity(surf);
            }
        });

        btnLlamarTelF.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String number = lblTel_F.getText().toString();
                Uri call = Uri.parse("tel:" + number);
                Intent surf = new Intent(Intent.ACTION_DIAL, call);
                startActivity(surf);
            }
        });
        btnLlamarTelM.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String number = lblTel_M.getText().toString();
                Uri call = Uri.parse("tel:" + number);
                Intent surf = new Intent(Intent.ACTION_DIAL, call);
                startActivity(surf);
            }
        });
        btnMensajeTelF.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String message = "[Mensaje enviado desde 'Mi Bisne']";
                String phoneNo = lblTel_F.getText().toString();
                Intent smsIntent = new Intent(Intent.ACTION_SENDTO, Uri.parse("smsto:" + phoneNo));
                smsIntent.putExtra("sms_body", message);
                startActivity(smsIntent);
            }
        });
        btnMensajeTelM.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String message = "[Mensaje enviado desde 'Mi Bisne']";
                String phoneNo = lblTel_M.getText().toString();
                Intent smsIntent = new Intent(Intent.ACTION_SENDTO, Uri.parse("smsto:" + phoneNo));
                smsIntent.putExtra("sms_body", message);
                startActivity(smsIntent);
            }
        });
        btnVerMapa.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(getApplicationContext(),"Cargando Mapa...",Toast.LENGTH_LONG).show();
            }
        });
        btnCorreoElect.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent emailIntent = new Intent(Intent.ACTION_SENDTO, Uri.fromParts("mailto", lblEmail.getText().toString(), null));
                emailIntent.putExtra(Intent.EXTRA_SUBJECT, "Correo Enviado desde 'Mi Bisne' ");
                startActivity(Intent.createChooser(emailIntent, "Enviar email."));
            }
        });
    }
    /*Cargar Datos de Negocio*/
    private void CargarDatosNegocio(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(ActivityDetallesAnuncio.this, "Cargando datos...","Espere por favor...",false,true);
        //mProgress.show();
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/GetNegocio.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //Log.d("OnResponse ",s);
                        JSONArray ja = null;
                        try {
                            ja = new JSONArray(s);
                            if (ja.getString(0).toString().trim().equals("Ha ocurrido un error inténtelo más tarde")){
                                Toast.makeText(ActivityDetallesAnuncio.this,"Error al cargar datos" , Toast.LENGTH_LONG).show();
                            }else {
                                for (int i = 0; i <ja.length(); i++) {
                                    setTitle("Detalles de " + ja.getString(2).toString());
                                    lblIdUsuario.setText(ja.getString(0).toString());
                                    lblIdNegocio.setText(ja.getString(1).toString());
                                    lblValoracion.setText("Danos tu valoración para el negocio " + ja.getString(2));
                                    lblNombreNegocio.setText(ja.getString(2).toString());
                                    lblDescripcion.setText(ja.getString(3).toString());
                                    lblDireccion.setText(ja.getString(4).toString());
                                    lblHorario.setText(ja.getString(5).toString());
                                    if (ja.getString(6).toString().equals("0")){
                                        lblTel_F.setVisibility(View.GONE);
                                        buttosTelF.setVisibility(View.GONE);
                                    }else {
                                        lblTel_F.setText(ja.getString(6).toString());
                                    }
                                    if (ja.getString(7).toString().equals("0")){
                                        lblTel_M.setVisibility(View.GONE);
                                        buttosTelM.setVisibility(View.GONE);
                                    }else {
                                        lblTel_M.setText(ja.getString(7).toString());
                                    }
                                    lblEmail.setText(ja.getString(8).toString());
                                    if (ja.getString(9).toString().equals("Desconocido")){
                                        lblSitioWeb.setVisibility(View.GONE);
                                    }else {
                                        lblSitioWeb.setText(ja.getString(9).toString());
                                    }
                                    if (ja.getString(10).toString().equals("Desconocido")){
                                        lblFacebook.setVisibility(View.GONE);
                                    }else {
                                        lblFacebook.setText(ja.getString(10).toString());
                                    }
                                    if (ja.getString(11).toString().equals("Desconocido")){
                                        lblInstagram.setVisibility(View.GONE);
                                    }else {
                                        lblInstagram.setText(ja.getString(11).toString());
                                    }
                                    if (ja.getString(12).toString().equals("Desconocido")){
                                        lblOtraRed.setVisibility(View.GONE);
                                    }else {
                                        lblOtraRed.setText(ja.getString(12).toString());
                                    }
                                    if (ja.getString(13).toString().equals("Desconocido")){
                                        lblTwitter.setVisibility(View.GONE);
                                    }else {
                                        lblTwitter.setText(ja.getString(13).toString());
                                    }
                                    PosicionGPS = ja.getString(14).toString();
                                    String arreglo[]=s.split("\\[");
                                    ratingBar.setNumStars(5);
                                    ratingBar.setRating(Float.parseFloat(ja.getString(19).toString()));
                                    //lblValoracion.setText("Valoraciond del Negocio " + ja.getString(2).toString());
                                    //Conversor se url
                                    String Url1 = ja.getString(20).toString();
                                    //String extraerp = Url1.substring(0,1);
                                    //String extraeru = Url1.substring(Url1.length()-1);
                                    //String remplazado=Url1.replace(extraerp,"");
                                    //String urloriginal=remplazado.replace(extraeru, "");
                                    //Elimina todas las  Diagonales \\ de la direccion URL que causan error
                                    String arrayoriginalurl1[]=Url1.split("\\\\");
                                    String newUrl = "";
                                    //Ciclo para ajustar el valor de la URL a un valor reconocido por Glide
                                    for (int q =0; q<arrayoriginalurl1.length; q++){
                                        newUrl += arrayoriginalurl1[q];
                                    }
                                    //Log.d("url1 ",newUrl);
                                    //Asignacion del Valor limpio a la variable global para guardar en el Array
                                    Glide.with(ActivityDetallesAnuncio.this)
                                            .load(newUrl)
                                            .thumbnail(Glide.with(ActivityDetallesAnuncio.this).load(R.drawable.tiendaabarrotes).centerCrop())
                                            .skipMemoryCache(true)
                                            .override(200,200)
                                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                                            .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                                            .into(imageView1);
                                    String Url2 = ja.getString(21).toString();
                                    String arrayoriginalurl2[]=Url2.split("\\\\");
                                    String newUrl2 = "";
                                    //Ciclo para ajustar el valor de la URL a un valor reconocido por Glide
                                    for (int q =0; q<arrayoriginalurl2.length; q++){
                                        newUrl2 += arrayoriginalurl2[q];
                                    }
                                    Glide.with(ActivityDetallesAnuncio.this)
                                            .load(newUrl2)
                                            .thumbnail(Glide.with(ActivityDetallesAnuncio.this).load(R.drawable.tiendaabarrotes).centerCrop())
                                            .skipMemoryCache(true)
                                            .override(200,200)
                                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                                            .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                                            .into(imageView2);
                                    String Url3 = ja.getString(22).toString();
                                    String arrayoriginalurl3[]=Url3.split("\\\\");
                                    String newUrl3 = "";
                                    //Ciclo para ajustar el valor de la URL a un valor reconocido por Glide
                                    for (int q =0; q<arrayoriginalurl3.length; q++){
                                        newUrl3 += arrayoriginalurl3[q];
                                    }
                                    Glide.with(ActivityDetallesAnuncio.this)
                                            .load(newUrl3)
                                            .thumbnail(Glide.with(ActivityDetallesAnuncio.this).load(R.drawable.tiendaabarrotes).centerCrop())
                                            .skipMemoryCache(true)
                                            .override(200,200)
                                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                                            .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                                            .into(imageView3);
                                    //Log.d("Datos URLS url1 " , newUrl + " url2: " + newUrl2 + " url3: " + newUrl3);
                                }
                                loading.dismiss();
                                contador ++;
                                //Convertir Latitud y longitud
                                String LatLng[]=PosicionGPS.split("\\_");
                                String lat = LatLng[0];
                                Latitud=lat.replace("Latitud:", "");
                                String lng = LatLng[1];
                                Longitud = lng.replace("Longitud:","");
                                //END de Convertir Latitud y longitud
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Descartar el diálogo de progreso
                        loading.dismiss();
                        //Showing toast
                        Toast.makeText(ActivityDetallesAnuncio.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                        Log.d("Datos Negocios", volleyError.getMessage().toString());
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                Log.d("Valor en put",IdNegocio);
                params.put(KEY_IDNEGOCIO, IdNegocio);
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityDetallesAnuncio.this.getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }

    //CArga el Movimiento de lasImagenes
    public void onClick() {
        viewFlipper.setAutoStart(true);
        viewFlipper.startFlipping();
        viewFlipper.setFlipInterval(3000);
    }

    private void GuardarValoracion(){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/SetCalificacion.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        JSONArray ja = null;
                        try {
                            ja = new JSONArray(s);
                            Toast.makeText(ActivityDetallesAnuncio.this,ja.getString(0).toString(),Toast.LENGTH_LONG).show();
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Showing toast
                        Log.d("Datos Negocios", volleyError.getMessage().toString());
                        Toast.makeText(ActivityDetallesAnuncio.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(KEY_IDNEGOCIO, IdNegocio);
                params.put(KEY_IDUSUARIO, MainActivity.emailActivo.toString());
                params.put(KEY_CALIFICACION, Calificacion);
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityDetallesAnuncio.this.getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }

    //Cambia Visibilidad para los detalles del usuario
    public void DetallesDeNegocio() {
        if (ValorActual == 1){
            if (ContenedorDetallesGeneral.getVisibility() == View.GONE) {
                ExpandAndCollapseViewUtil.expand(ContenedorDetallesGeneral, DURATION);
                imageViewExpand1.setImageResource(R.mipmap.more);
                rotateuser(-180.0f);
            } else {
                ExpandAndCollapseViewUtil.collapse(ContenedorDetallesGeneral, DURATION);
                imageViewExpand1.setImageResource(R.mipmap.less);
                rotateuser(180.0f);
            }
        }
        if (ValorActual == 2){
            if (ContenedorDetallesContacto.getVisibility() == View.GONE) {
                ExpandAndCollapseViewUtil.expand(ContenedorDetallesContacto, DURATION);
                imageViewExpand2.setImageResource(R.mipmap.more);
                rotateuser(-180.0f);
            } else {
                ExpandAndCollapseViewUtil.collapse(ContenedorDetallesContacto, DURATION);
                imageViewExpand2.setImageResource(R.mipmap.less);
                rotateuser(180.0f);
            }
        }
        if (ValorActual == 3){
            if (ContenedorDetallesSocial.getVisibility() == View.GONE) {
                ExpandAndCollapseViewUtil.expand(ContenedorDetallesSocial, DURATION);
                imageViewExpand3.setImageResource(R.mipmap.more);
                rotateuser(-180.0f);
            } else {
                ExpandAndCollapseViewUtil.collapse(ContenedorDetallesSocial, DURATION);
                imageViewExpand3.setImageResource(R.mipmap.less);
                rotateuser(180.0f);
            }
        }
    }

    /*Animaciones de rotamiento */
    private void rotateuser(float angle) {
        Animation animation = new RotateAnimation(0.0f, angle, Animation.RELATIVE_TO_SELF, 0.5f,
                Animation.RELATIVE_TO_SELF, 0.5f);
        animation.setFillAfter(true);
        animation.setDuration(DURATION);
        if (ValorActual == 1){
            imageViewExpand1.startAnimation(animation);
        }
        if (ValorActual == 2){
            imageViewExpand2.startAnimation(animation);
        }
        if (ValorActual == 3){
            imageViewExpand3.startAnimation(animation);
        }
    }

    private void GetTicket(){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/SetTicket.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        Log.d("OnResponse ", s);
                        JSONArray ja = null;
                        try {
                            ja = new JSONArray(s);
                            //Toast.makeText(ActivityDetallesAnuncio.this,ja.getString(0).toString(),Toast.LENGTH_LONG).show();
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Toast.makeText(ActivityDetallesAnuncio.this, e.toString(),Toast.LENGTH_LONG).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Showing toast
                        Log.d("Datos Negocios", volleyError.getMessage().toString());
                        Toast.makeText(ActivityDetallesAnuncio.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(KEY_IDUSUARIO, MainActivity.emailActivo.toString());
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityDetallesAnuncio.this.getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }

}
