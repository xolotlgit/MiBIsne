package com.example.deadshot.elbisne;

import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.net.Uri;
import android.support.design.widget.TextInputEditText;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
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

import java.io.File;
import java.io.FileOutputStream;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.Hashtable;
import java.util.Locale;
import java.util.Map;

public class ActivityDetallesNegocio extends AppCompatActivity {

    //Id del Negocio Seleccionado
    String IdNegocio;
    //Dato para Enviar al Servidor
    private String KEY_IDNEGOCIO = "IdNegocio";
    String Ruta = MainActivity.RutaWeb;

    //Variables dentro del layoud Activy detallesAnuncio
    TextInputEditText lblIdUsuario,lblIdNegocio,lblDescripcion,lblDireccion,lblHorario,lblTel_F,lblTel_M,lblEmail,lblSitioWeb,lblFacebook,lblTwitter,lblOtraRed,lblFechIni,lblFechFin,lblInstagram,lblCategoria;
    TextView lblNombreNegocio,lblStatus,lblValoracion;
    String PosicionGPS ="";
    ImageView imageView1,imageView2,imageView3,imgStatus;
    ViewFlipper viewFlipper;
    RatingBar ratingBar;
    //Witget para expand&andCollapse de los datos
    private static final int DURATION = 250;
    private ViewGroup linearLayoutCardContent, ContenedorDetallesGeneral, ContenedorDetallesContacto, ContenedorDetallesSocial;
    private ImageView imageViewExpand1,imageViewExpand2,imageViewExpand3;
    int ValorActual=0;
    //Editar Datos Negocio
    Button btnEditarDatosNegocio,btnCancelarDatosNegocio,btnGuardarDatosNegocio,btnCompartir;
    private  ViewGroup linearLayoutCardContent2, ContenedorDetallesGeneral2, ContenedorDetallesContacto2, ContenedorDetallesSocial2;
    TextInputEditText lblNombreNegocioedit2,lblDescripcion2,lblDireccion2,lblHorario2,lblTel_F2,lblTel_M2,lblEmail2,lblSitioWeb2,lblFacebook2,lblTwitter2,lblOtraRed2,lblInstagram2,lblTags2;
    private ImageView imageViewExpand12,imageViewExpand22,imageViewExpand32;

    //Variables para Guardar Datos del Negocio
    private String KEY_IdNegocio = "IdNegocio";
    private String Nombre_Negocio = "Nombre_Negocio";
    private String Descripcion = "Descripcion";
    private String Direccion_N = "Direccion_N";
    private String Horario = "Horario";
    private String Telefono_F = "Telefono_F";
    private String Telefono_M = "Telefono_M";
    private String Email_N = "Email_N";
    private String Sitio_Web = "Sitio_Web";
    private String Facebook = "Facebook";
    private String Twitter = "Twitter";
    private String Instagram = "Instagram";
    private String Otra_Red = "Otra_Red";

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
        setContentView(R.layout.activity_detalles_negocio);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);

        //Variables de los campos de Texto que contiene los datos del negocio
        lblIdNegocio = (TextInputEditText)findViewById(R.id.lblIdNegocio);
        lblIdUsuario = (TextInputEditText)findViewById(R.id.lblIdUsuario);
        lblNombreNegocio = (TextView) findViewById(R.id.lblNombreNegocio);
        lblDescripcion = (TextInputEditText)findViewById(R.id.lblDescripcion);
        lblDireccion = (TextInputEditText)findViewById(R.id.lblDireccion);
        lblHorario = (TextInputEditText)findViewById(R.id.lblHorario);
        lblTel_F = (TextInputEditText)findViewById(R.id.lblTel_F);
        lblTel_M = (TextInputEditText)findViewById(R.id.lblTel_M);
        lblEmail = (TextInputEditText)findViewById(R.id.lblEmail);
        lblSitioWeb = (TextInputEditText)findViewById(R.id.lblSitioWeb);
        lblFacebook = (TextInputEditText)findViewById(R.id.lblFacebook);
        lblInstagram = (TextInputEditText)findViewById(R.id.lblInstagram);
        lblTwitter = (TextInputEditText)findViewById(R.id.lblTwitter);
        lblOtraRed= (TextInputEditText)findViewById(R.id.lblOtraRed);
        lblFechIni = (TextInputEditText)findViewById(R.id.lblFechIni);
        lblFechFin = (TextInputEditText)findViewById(R.id.lblFechFin);
        lblCategoria =(TextInputEditText)findViewById(R.id.lblCategoria);
        lblStatus = (TextView)findViewById(R.id.lblStatus);
        imageView1 = (ImageView)findViewById(R.id.imageView1);
        imageView2 = (ImageView)findViewById(R.id.imageView2);
        imageView3 = (ImageView)findViewById(R.id.imageView3);
        imgStatus = (ImageView)findViewById(R.id.imgStatus);
        //END Variables de los campos de Texto que contiene los datos del negocio
        //ViewFliper que contiene las 3 imagenes delnegocio
        viewFlipper = (ViewFlipper)this.findViewById(R.id.viewFlipperImgNegocio);
        //END ViewFliper que contiene las 3 imagenes delnegocio
        //RatingBar para la valoracion del negocio
        ratingBar = (RatingBar) findViewById(R.id.ratingBar);
        //END RatingBar para la valoracion del negocio

        //elementos para editar los datos del Negocio
        btnEditarDatosNegocio = (Button)findViewById(R.id.btnEditarDatosNegocio);
        btnGuardarDatosNegocio = (Button)findViewById(R.id.btnGuardarDatosNegocio);
        btnCancelarDatosNegocio = (Button)findViewById(R.id.btnCancelarDatosNegocio);
        linearLayoutCardContent = (ViewGroup)findViewById(R.id.linearLayoutCardContent);
        linearLayoutCardContent2 = (ViewGroup)findViewById(R.id.linearLayoutCardContent2);

        //Variables de los campos de editar datos del negocio
        lblNombreNegocioedit2 = (TextInputEditText) findViewById(R.id.lblNombreNegocioedit2);
        lblDescripcion2 = (TextInputEditText)findViewById(R.id.lblDescripcion2);
        lblDireccion2 = (TextInputEditText)findViewById(R.id.lblDireccion2);
        lblHorario2 = (TextInputEditText)findViewById(R.id.lblHorario2);
        lblTel_F2 = (TextInputEditText)findViewById(R.id.lblTel_F2);
        lblTel_M2 = (TextInputEditText)findViewById(R.id.lblTel_M2);
        lblEmail2 = (TextInputEditText)findViewById(R.id.lblEmail2);
        lblSitioWeb2 = (TextInputEditText)findViewById(R.id.lblSitioWeb2);
        lblFacebook2 = (TextInputEditText)findViewById(R.id.lblFacebook2);
        lblInstagram2 = (TextInputEditText)findViewById(R.id.lblInstagram2);
        lblTwitter2 = (TextInputEditText)findViewById(R.id.lblTwitter2);
        lblOtraRed2 = (TextInputEditText)findViewById(R.id.lblOtraRed2);

        //Linerar Layout que contiene los datos(Detalles) de cada Seccion
        ContenedorDetallesGeneral2 = (ViewGroup)findViewById(R.id.ContenedorDetallesGeneral2);
        ContenedorDetallesContacto2 = (ViewGroup)findViewById(R.id.ContenedorDetallesContacto2);
        ContenedorDetallesSocial2 = (ViewGroup)findViewById(R.id.ContenedorDetallesSocial2);
        //END Linerar Layout que contiene los datos(Detalles) de cada Seccion
        //Imagen de Expand para cada Seccion
        imageViewExpand12 = (ImageView)findViewById(R.id.imageViewExpand12);
        imageViewExpand22 = (ImageView)findViewById(R.id.imageViewExpand22);
        imageViewExpand32 = (ImageView)findViewById(R.id.imageViewExpand32);
        //END Imagen de Expand para cada Seccion

        //END Variables de los campos de editar datos del negocio

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

        //Listenr de expand Detalles show negocio

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
        //END Listenr de expand Detalles show negocio

        //Listenr de expand Detalles edit negocio

        LinearLayout btnDetallesGeneralNegocio2 = (LinearLayout)findViewById(R.id.btnDetallesGeneralNegocio2);
        LinearLayout btnDetallesContactoNegocio2 = (LinearLayout)findViewById(R.id.btnDetallesContactoNegocio2);
        LinearLayout btnDetallesSocialNegocio2 = (LinearLayout)findViewById(R.id.btnDetallesSocialNegocio2);

        btnDetallesGeneralNegocio2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ValorActual =1;
                DetallesDeNegocio2();
            }
        });
        btnDetallesContactoNegocio2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ValorActual =2;
                DetallesDeNegocio2();
            }
        });
        btnDetallesSocialNegocio2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ValorActual =3;
                DetallesDeNegocio2();
            }
        });
        //END Listenr de expand Detalles edit negocio


        btnEditarDatosNegocio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                linearLayoutCardContent.setVisibility(View.GONE);
                linearLayoutCardContent2.setVisibility(View.VISIBLE);
            }
        });

        btnCancelarDatosNegocio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                linearLayoutCardContent2.setVisibility(View.GONE);
                linearLayoutCardContent.setVisibility(View.VISIBLE);
            }
        });

        btnGuardarDatosNegocio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GuardarDatosNegocio();
                linearLayoutCardContent2.setVisibility(View.GONE);
                linearLayoutCardContent.setVisibility(View.VISIBLE);
            }
        });

        IdNegocio ="";
        Bundle extras = getIntent().getExtras();
        if (extras != null){
            IdNegocio = extras.getString("IdNegocio");
            Log.d("Id del Negocio ", IdNegocio);
            //Elimina las "" de cada registro dejando solo el dato String con el IddelNegocio
            int cadena1 = IdNegocio.length();
            String extraerp = IdNegocio.substring(0,1);
            String extraeru = IdNegocio.substring(IdNegocio.length()-1);
            String remplazado=IdNegocio.replace(extraerp,"");
            IdNegocio=remplazado.replace(extraeru, "");
            CargarDatosNegocio();
            onClick();
        }else {
            Toast.makeText(ActivityDetallesNegocio.this,"A Ocurrido Un Error intentalo mas Tarde",Toast.LENGTH_LONG).show();
            finish();
        }

        btnCompartir = (Button)findViewById(R.id.btnCompartir);
        btnCompartir.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Compartit();
            }
        });
    }

    /*Cargar Negocios*/
    private void CargarDatosNegocio(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(ActivityDetallesNegocio.this, "Cargando Datos...","Espere por favor...",false,true);
        //mProgress.show();
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/GetNegocio.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        loading.dismiss();
                        Log.d("onResponse ",s);
                        JSONArray ja = null;

                        try {
                            ja = new JSONArray(s);
                            if (ja.getString(0).toString().trim().equals("Ha Ocurrido Un Error Intentelo Mas Tarde")){
                                Toast.makeText(ActivityDetallesNegocio.this, "Error Al Cargar Datos", Toast.LENGTH_LONG).show();
                            }else {

                                //for (int i = 0; i <ja.length(); i++) {
                                    setTitle("Detalles de " + ja.getString(2).toString());
                                    lblIdUsuario.setText(ja.getString(0).toString());
                                    lblIdNegocio.setText(ja.getString(1).toString());
                                    lblNombreNegocio.setText(ja.getString(2).toString());
                                    lblDescripcion.setText(ja.getString(3).toString());
                                    lblDireccion.setText(ja.getString(4).toString());
                                    lblHorario.setText(ja.getString(5).toString());
                                    lblTel_F.setText(ja.getString(6).toString());
                                    lblTel_M.setText(ja.getString(7).toString());
                                    lblEmail.setText(ja.getString(8).toString());
                                    /*Contenedor 2*/
                                    lblNombreNegocioedit2.setText(ja.getString(2).toString());
                                    lblDescripcion2.setText(ja.getString(3).toString());
                                    lblDireccion2.setText(ja.getString(4).toString());
                                    lblHorario2.setText(ja.getString(5).toString());
                                    lblTel_F2.setText(ja.getString(6).toString());
                                    lblTel_M2.setText(ja.getString(7).toString());
                                    lblEmail2.setText(ja.getString(8).toString());
                                    lblSitioWeb2.setText(ja.getString(9).toString());
                                    lblFacebook2.setText(ja.getString(10).toString());
                                    lblInstagram2.setText(ja.getString(11).toString());
                                    lblOtraRed2.setText(ja.getString(12).toString());
                                    lblTwitter2.setText(ja.getString(13).toString());
                                    /*END Contenedor2 datos */
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
                                    String fechIni = ja.getString(15).toString();
                                    //*INSTANCIA DE FECHAS*/
                                    SimpleDateFormat formatter = new SimpleDateFormat("MMMM", new Locale("es", "MX"));
                                    GregorianCalendar calendar = new GregorianCalendar();
                                    String DateEndOfWeek;
                                    ///Convertir Fecha Inicial
                                    String sepfechas[] = fechIni.split("\\-");
                                    int valormes = Integer.parseInt(sepfechas[1]);
                                    int valordia = Integer.parseInt(sepfechas[2]);
                                    calendar.set(Calendar.DAY_OF_MONTH, valordia);
                                    calendar.set(Calendar.MONTH, valormes-1);
                                    DateEndOfWeek = calendar.getDisplayName(Calendar.DAY_OF_WEEK, Calendar.LONG,  new Locale("es", "MX")).toLowerCase();
                                    //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                    lblFechIni.setText(DateEndOfWeek + " " + sepfechas[2] + " de " + formatter.format(calendar.getTime()) + " del " + sepfechas[0]);
                                    //End Parse Fecha Inicial
                                    ///Convertir Fecha FIN
                                    String fechFin = ja.getString(16).toString();
                                    String sepfechFin[] = fechFin.split("\\-");
                                    int valmes2 = Integer.parseInt(sepfechFin[1]);
                                    int valday2 = Integer.parseInt(sepfechFin[2]);
                                    calendar.set(Calendar.DAY_OF_MONTH, valday2);
                                    calendar.set(Calendar.MONTH, valmes2-1);
                                    DateEndOfWeek = calendar.getDisplayName(Calendar.DAY_OF_WEEK, Calendar.LONG,  new Locale("es", "MX")).toLowerCase();
                                    //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                    lblFechFin.setText(DateEndOfWeek + " " + sepfechFin[2] + " de " + formatter.format(calendar.getTime()) + " del " + sepfechFin[0]);
                                    //End Parse Fecha FIN

                                    lblCategoria.setText(ja.getString(17).toString());
                                    if (ja.getString(18).toString().equals("1")){
                                        //Configurando Fechas
                                        Date c = Calendar.getInstance().getTime();
                                        //get Año, mes y dia por separado
                                        SimpleDateFormat yyyy = new SimpleDateFormat("yyyy");
                                        SimpleDateFormat MM = new SimpleDateFormat("MM");
                                        SimpleDateFormat dd = new SimpleDateFormat("dd");
                                        String anotoday = yyyy.format(c);
                                        String mestoday = MM.format(c);
                                        String diatoday = dd.format(c);
                                        int lastday = valday2 - Integer.parseInt(diatoday);
                                        int lastmes = valmes2 - Integer.parseInt(mestoday);
                                        if (lastmes == 0 ){
                                            if (lastday == 1){
                                                lblStatus.setText("La suscripcion finaliza mañana");
                                            }else {
                                                lblStatus.setText("Tiempo Restante para Finalizar Suscripcion: " + lastday + " Dias");
                                            }
                                        }else if (lastmes >0 ){
                                            if (lastmes == 1){
                                                lblStatus.setText("Tiempo Restante para Finalizar Suscripcion: " + lastmes + " mes ");
                                            }else {
                                                lblStatus.setText("Tiempo Restante para Finalizar Suscripcion: " + lastmes + " meses ");
                                            }
                                        }
                                        imgStatus.setImageResource(R.mipmap.activo);
                                    }else {
                                        lblStatus.setText("Suscripcion Finalizada");
                                        imgStatus.setImageResource(R.mipmap.inactivo);
                                    }
                                    ratingBar.setNumStars(5);
                                    ratingBar.setRating(Float.parseFloat(ja.getString(19).toString()));
                                    //lblValoracion.setText("Valoraciond del Negocio " + ja.getString(2).toString());
                                    Glide.with(ActivityDetallesNegocio.this)
                                            .load(ja.getString(20).toString())
                                            .thumbnail(Glide.with(ActivityDetallesNegocio.this).load(R.drawable.tiendaabarrotes).centerCrop())
                                            .skipMemoryCache(true)
                                            .override(200,200)
                                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                                            .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                                            .into(imageView1);
                                    Glide.with(ActivityDetallesNegocio.this)
                                            .load(ja.getString(21).toString())
                                            .thumbnail(Glide.with(ActivityDetallesNegocio.this).load(R.drawable.tiendaabarrotes).centerCrop())
                                            .skipMemoryCache(true)
                                            .override(200,200)
                                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                                            .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                                            .into(imageView2);
                                    Glide.with(ActivityDetallesNegocio.this)
                                            .load(ja.getString(22).toString())
                                            .thumbnail(Glide.with(ActivityDetallesNegocio.this).load(R.drawable.tiendaabarrotes).centerCrop())
                                            .skipMemoryCache(true)
                                            .override(200,200)
                                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                                            .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                                            .into(imageView3);
                                //}
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
                        Toast.makeText(ActivityDetallesNegocio.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                        Log.d("Datos Negocios", volleyError.getMessage().toString());
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                Log.d("Valor Enviado ",IdNegocio);
                params.put(KEY_IDNEGOCIO, IdNegocio);
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityDetallesNegocio.this.getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }

    private void GuardarDatosNegocio(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(this,"Guardando Negocio","Espere por favor...",false,false);
        //mProgress.show();
        StringRequest stringRequest = new StringRequest(Request.Method.POST, MainActivity.RutaWeb + "/consultasdbNegocios/UpdateNegocio.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //Descartar el diálogo de progreso
                        loading.dismiss();
                        //Mostrando el mensaje de la respuesta

                        if (s.equals("Datos actualizados")){
                            lblNombreNegocio.setText(lblNombreNegocioedit2.getText().toString().trim());
                            lblDescripcion.setText(lblDescripcion2.getText().toString().trim());
                            lblDireccion.setText(lblDireccion2.getText().toString().trim());
                            lblHorario.setText(lblHorario2.getText().toString().trim());
                            lblTel_F.setText(lblTel_F2.getText().toString().trim());
                            lblTel_M.setText(lblTel_M2.getText().toString().trim());
                            lblEmail.setText(lblEmail2.getText().toString().trim());
                            lblSitioWeb.setText(lblSitioWeb2.getText().toString().trim());
                            lblFacebook.setText(lblFacebook2.getText().toString().trim());
                            lblTwitter.setText(lblTwitter2.getText().toString().trim());
                            lblInstagram.setText(lblInstagram2.getText().toString().trim());
                            lblOtraRed.setText(lblOtraRed2.getText().toString().trim());
                            Toast.makeText(ActivityDetallesNegocio.this, s , Toast.LENGTH_LONG).show();
                        }else {
                            Toast.makeText(ActivityDetallesNegocio.this, s , Toast.LENGTH_LONG).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Descartar el diálogo de progreso
                        loading.dismiss();
                        //Showing toast
                        Toast.makeText(ActivityDetallesNegocio.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                        Log.d("Volley Error ", volleyError.getMessage().toString());
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(KEY_IDNEGOCIO, IdNegocio);
                params.put(Nombre_Negocio , lblNombreNegocioedit2.getText().toString().trim());
                params.put(Descripcion , lblDescripcion2.getText().toString().trim());
                params.put(Direccion_N , lblDireccion2.getText().toString().trim());
                params.put(Horario , lblHorario2.getText().toString().trim());
                params.put(Telefono_F , lblTel_F2.getText().toString().trim());
                params.put(Telefono_M , lblTel_M2.getText().toString().trim());
                params.put(Email_N , lblEmail2.getText().toString().trim());
                params.put(Sitio_Web ,lblSitioWeb2.getText().toString().trim());
                params.put(Facebook ,lblFacebook2.getText().toString().trim());
                params.put(Twitter , lblTwitter2.getText().toString().trim());
                params.put(Instagram , lblInstagram2.getText().toString().trim());
                params.put(Otra_Red , lblOtraRed2.getText().toString().trim());
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityDetallesNegocio.this.getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }

    /*Inicia Animacion para las Imagenes*/
    public void onClick() {
        viewFlipper.setAutoStart(true);
        viewFlipper.startFlipping();
        viewFlipper.setFlipInterval(3000);
    }

    //Cambia Visibilidad para los detalles del negocio show
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

    public static int restarFechas(Date fechaIn, Date fechaFinal ){
        GregorianCalendar fechaInicio= new GregorianCalendar();
        fechaInicio.setTime(fechaIn);
        GregorianCalendar fechaFin= new GregorianCalendar();
        fechaFin.setTime(fechaFinal);
        int dias = 0;
        if(fechaFin.get(Calendar.YEAR)==fechaInicio.get(Calendar.YEAR)){

            dias =(fechaFin.get(Calendar.DAY_OF_YEAR)- fechaInicio.get(Calendar.DAY_OF_YEAR))+1;
        }else{
            int rangoAnyos = fechaFin.get(Calendar.YEAR) - fechaInicio.get(Calendar.YEAR);

            for(int i=0;i<=rangoAnyos;i++){
                int diasAnio = fechaInicio.isLeapYear(fechaInicio.get(Calendar.YEAR)) ? 366 : 365;
                if(i==0){
                    dias=1+dias +(diasAnio- fechaInicio.get(Calendar.DAY_OF_YEAR));
                }else	if(i==rangoAnyos){
                    dias=dias +fechaFin.get(Calendar.DAY_OF_YEAR);
                }else{
                    dias=dias+diasAnio;
                }
            }
        }

        return dias;

    }

    public void Compartit(){
        ImageView imagen;

        imagen = (ImageView)findViewById(R.id.imageView1);

        imagen.buildDrawingCache();
        Bitmap bitmap = imagen.getDrawingCache();

        /***** COMPARTIR IMAGEN *****/
        try {
            File file = new File(getCacheDir(), bitmap + ".png");
            FileOutputStream fOut = null;
            fOut = new FileOutputStream(file);
            bitmap.compress(Bitmap.CompressFormat.PNG, 100, fOut);
            fOut.flush();
            fOut.close();
            file.setReadable(true, false);
            //final Intent intent = new Intent(android.content.Intent.ACTION_SEND);
            Intent sendIntent = new Intent();
            sendIntent.setAction(Intent.ACTION_SEND);
            sendIntent.putExtra(Intent.EXTRA_TEXT, "Te Invito a conocer mi negocio: " + lblNombreNegocio.getText().toString() + ". \n Desde la aplicación Mi Bisne. \n https://play.google.com/store/apps/developer?id=Xolotl+Creative+Labs");
            sendIntent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            sendIntent.putExtra(Intent.EXTRA_STREAM, Uri.fromFile(file));
            sendIntent.setType("image/png");
            startActivity(sendIntent);

        } catch (Exception e) {
            e.printStackTrace();
            Toast.makeText(getApplicationContext(),"Ha ocurrido un error inténtalo más tarde.",Toast.LENGTH_LONG).show();
        }
    }

    //Cambia Visibilidad para los detalles del negocio edit
    public void DetallesDeNegocio2() {
        if (ValorActual == 1){
            if (ContenedorDetallesGeneral2.getVisibility() == View.GONE) {
                ExpandAndCollapseViewUtil.expand(ContenedorDetallesGeneral2, DURATION);
                imageViewExpand12.setImageResource(R.mipmap.more);
                rotatenego2(-180.0f);
            } else {
                ExpandAndCollapseViewUtil.collapse(ContenedorDetallesGeneral2, DURATION);
                imageViewExpand12.setImageResource(R.mipmap.less);
                rotatenego2(180.0f);
            }
        }
        if (ValorActual == 2){
            if (ContenedorDetallesContacto2.getVisibility() == View.GONE) {
                ExpandAndCollapseViewUtil.expand(ContenedorDetallesContacto2, DURATION);
                imageViewExpand22.setImageResource(R.mipmap.more);
                rotatenego2(-180.0f);
            } else {
                ExpandAndCollapseViewUtil.collapse(ContenedorDetallesContacto2, DURATION);
                imageViewExpand22.setImageResource(R.mipmap.less);
                rotatenego2(180.0f);
            }
        }
        if (ValorActual == 3){
            if (ContenedorDetallesSocial2.getVisibility() == View.GONE) {
                ExpandAndCollapseViewUtil.expand(ContenedorDetallesSocial2, DURATION);
                imageViewExpand32.setImageResource(R.mipmap.more);
                rotatenego2(-180.0f);
            } else {
                ExpandAndCollapseViewUtil.collapse(ContenedorDetallesSocial2, DURATION);
                imageViewExpand32.setImageResource(R.mipmap.less);
                rotatenego2(180.0f);
            }
        }
    }

    /*Animaciones de rotamiento 2*/
    private void rotatenego2(float angle) {
        Animation animation = new RotateAnimation(0.0f, angle, Animation.RELATIVE_TO_SELF, 0.5f,
                Animation.RELATIVE_TO_SELF, 0.5f);
        animation.setFillAfter(true);
        animation.setDuration(DURATION);
        if (ValorActual == 1){
            imageViewExpand12.startAnimation(animation);
        }
        if (ValorActual == 2){
            imageViewExpand22.startAnimation(animation);
        }
        if (ValorActual == 3){
            imageViewExpand32.startAnimation(animation);
        }
    }
}
