package com.example.deadshot.elbisne;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.design.widget.TextInputEditText;
import android.support.v4.app.Fragment;
import android.util.Base64;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

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

import java.io.ByteArrayOutputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.Hashtable;
import java.util.Map;
import java.io.IOException;

public class Tab3 extends Fragment {

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    //Ruta del Servidor Web
    String Ruta = MainActivity.RutaWeb;

    //Variables para Cargar Imagenes
    //public static TextInputEditText Url1Nego,Url2Nego, Url3Nego;
    //Varibales para textos del Tab3_fragment
    //Spinner CboxImagenSelect;
    Button btnSaveNego;

    private ProgressDialog mProgress;
    //private ViewGroup ContenedorImagenes, ContenedorUrl;
    private static final int DURATION = 250;
    //public int Oculto = 0;
    //End Variables para cargar Usuario

    /*Variables para Guardar Negocios*/
    private ImageView  img1,img2,img3;
    private TextView textViewError;
    private Bitmap bitmap1,bitmap2,bitmap3;
    private int PICK_IMAGE_REQUEST = 1;
    private String UPLOAD_URLLocal ="http://10.0.2.2/";
    public static String UPLOAD_URL="http://www.elbisne.xolotlcl.com/";
    private String KEY_IMAGEN1 = "foto1";
    private String KEY_IMAGEN2 = "foto2";
    private String KEY_IMAGEN3 = "foto3";
    private String IdUsuario = "IdUsuario";
    private String Nombre_Negocio = "Nombre_Negocio";
    private String Descripcion = "Descripcion";
    private String Direccion_N = "Direccion_N";
    private String Horario = "Horario";
    private String Telefono_F = "Telefono_F";
    private String Telefono_M = "Telefono_M";
    private String IdCategoria = "IdCategoria";
    private String Email_N = "Email_N";
    private String Sitio_Web = "Sitio_Web";
    private String Facebook = "Facebook";
    private String Twitter = "Twitter";
    private String Instagram = "Instagram";
    private String Otra_Red = "Otra_Red";
    private String Tags = "Tags";
    private String Posicion_GPS ="Posicion_GPS";
    public int valor =0;
    //Indicializacion como -Null las variables para imagenes
    String imagen1 = "null";
    String imagen2 = "null";
    String imagen3 = "null";
    //Variables para guardar valores
    String idusuario, nombrenegocio, descripcion, direccion,horario,telefonof,telefonom,idcategoria,emailnegocio,sitioweb,facebook,twitter,instagram,otrared,tags,posicion_gps;

    private OnFragmentInteractionListener mListener;

    public Tab3() {
        // Required empty public constructor
    }

    // TODO: Rename and change types and number of parameters
    public static Tab3 newInstance(String param1, String param2) {
        Tab3 fragment = new Tab3();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        //return inflater.inflate(R.layout.fragment_tab3, container, false);
        // Inflate the layout for this fragment
        View rootView3 = inflater.inflate(R.layout.fragment_tab3, container, false);

        //Variables del Fragmetn de registro1
        btnSaveNego = (Button)rootView3.findViewById(R.id.btnSaveRegNegociosGeneral);
        mProgress = new ProgressDialog(getContext());
        //textViewError = (TextView) findViewById(R.id.textViewError);

        /*CboxImagenSelect = (Spinner)rootView3.findViewById(R.id.cboxImagenSeleted);
        //Instancia para las imagenes por URL
        Url1Nego = (TextInputEditText)rootView3.findViewById(R.id.txtUrlImg1);
        Url2Nego = (TextInputEditText)rootView3.findViewById(R.id.txtUrlImg2);
        Url3Nego = (TextInputEditText)rootView3.findViewById(R.id.txtUrlImg3);*/
        //Instancia para las imagenes por Archivo
        img1 = (ImageView)rootView3.findViewById(R.id.img1Negocio);
        img2 = (ImageView)rootView3.findViewById(R.id.img2Negocio);
        img3 = (ImageView)rootView3.findViewById(R.id.img3Negocio);

        textViewError = (TextView)rootView3.findViewById(R.id.textViewError);

        /*/linear layud Imagenes
        ContenedorImagenes = (ViewGroup)rootView3.findViewById(R.id.contenedorImagenes);
        ContenedorUrl = (ViewGroup)rootView3.findViewById(R.id.contenedorUrl);

        String [] values =
                {"Seleccione una opción","Imágenes de galería","URL de la imagen"};
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this.getActivity(), android.R.layout.simple_spinner_item, values);
        adapter.setDropDownViewResource(android.R.layout.simple_dropdown_item_1line);
        CboxImagenSelect.setAdapter(adapter);

        CboxImagenSelect.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                if (CboxImagenSelect.getSelectedItem().toString().equals("Imágenes de galería")){
                    ContenedorImagenes.setVisibility(View.VISIBLE);
                    ContenedorUrl.setVisibility(View.GONE);
                }else if (CboxImagenSelect.getSelectedItem().toString().equals("URL de la imagen")){
                    ContenedorImagenes.setVisibility(View.GONE);
                    ContenedorUrl.setVisibility(View.VISIBLE);
                    imagen1 ="null";imagen3 ="null";imagen3 ="null";
                }else {
                    Toast.makeText(getActivity(), "Seleccione una opción",Toast.LENGTH_LONG).show();
                    ContenedorImagenes.setVisibility(View.GONE);
                    ContenedorUrl.setVisibility(View.GONE);
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });*/
        //Listener del Boton de Guardar NEgocios
        btnSaveNego.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Validaciones();
            }
        });

        //Listener de Los ImageView
        img1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                valor= 1;
                OpenGaleria();
            }
        });

        img2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                valor= 2;
                OpenGaleria();
            }
        });
        img3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                valor=3;
                OpenGaleria();
            }
        });
        //End Listener de los ImageButton

        return rootView3;
    }
    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);

        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }

    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }

    public String Limpiar(String Cambiar){
        String A,E,I,O,U,a,e,i,o,u;
        a = Cambiar.replaceAll("á","a");
        A = a.replaceAll("Á","A");
        e = A.replaceAll("é","e");
        E = e.replaceAll("É","E");
        i = E.replaceAll("í","i");
        I = i.replaceAll("Í","I");
        o = I.replaceAll("ó","o");
        O = o.replaceAll("Ó","O");
        u = O.replaceAll("ú","u");
        U = u.replaceAll("Ú","U");
        return U;
    } //end Limpiar

    /*METODOS PARA EL REGISTRO DE NEGOCIOS*/
    public void Validaciones(){
        //Obtener el nombre de la imagen
        idusuario = Tab1.Iduser.getText().toString().trim();
        nombrenegocio = Limpiar(Tab1.NombreNego.getText().toString().trim());
        descripcion = Limpiar(Tab1.DescripcionNego.getText().toString().trim());
        direccion = Limpiar(Tab1.DireccionNego.getText().toString().trim());
        horario = Limpiar(Tab1.HorarioNego.getText().toString().trim());
        telefonof = Limpiar(Tab1.TelFNego.getText().toString().trim());
        telefonom = Limpiar(Tab1.TelMNego.getText().toString().trim());
        idcategoria = Tab1.CboxCategorias.getSelectedItem().toString();
        emailnegocio = Limpiar(Tab2.CorreoNego.getText().toString().trim());
        sitioweb = Limpiar(Tab2.SitioNego.getText().toString().trim());
        facebook = Limpiar(Tab2.faceNego.getText().toString().trim());
        twitter = Limpiar(Tab2.TuiwerNego.getText().toString().trim());
        instagram = Limpiar(Tab2.InstagramNego.getText().toString().trim());
        otrared = Limpiar(Tab2.OtraRNego.getText().toString().trim());
        tags = Limpiar(Tab2.TagsNego.getText().toString().trim());

        String Linpio = tags.replaceAll("\\,","");
        String arreglo[]=Linpio.split(" ");

        for (int a=0; a<arreglo.length; a++) {
            if (a <= 3){
                Tags += arreglo[a]+" ";
            }
        }
        tags = tags;
        posicion_gps = MainActivity.PosicionGps;
        if(sitioweb.equals("") || facebook.equals("") || twitter.equals("") || instagram.equals("") || otrared.equals("") || telefonof.equals("") || telefonom.equals("") ){
            if (sitioweb.equals("")){
                sitioweb = "Desconocido";
            }
            if (facebook.equals("")){
                facebook = "Desconocido";
            }
            if (twitter.equals("")){
                twitter = "Desconocido";
            }
            if (instagram.equals("")){
                instagram = "Desconocido";
            }
            if (otrared.equals("")){
                otrared = "Desconocido";
            }
            if (telefonof.equals("") && telefonom.equals("")){
                Toast.makeText(getActivity(), "Debes Tener Almenos un Telefono", Toast.LENGTH_LONG).show();
            }
            if (telefonof.equals("") || telefonom.equals("")){
                if (telefonof.equals("") && telefonom.length() > 1){
                    telefonof = "0";
                }
                if (telefonom.equals("") && telefonof.length() > 1){
                    telefonom = "0";
                }
            }
        }
        if(nombrenegocio.equals("") || descripcion.equals("") || direccion.equals("") || horario.equals("") || idcategoria.equals("Seleccione una Categoria") || emailnegocio.equals("")){
            Toast.makeText(getActivity(), "Existen Campos Vacios", Toast.LENGTH_LONG).show();
        }else if (idusuario.equals("") || idusuario.equals(null)){
            Toast.makeText(getActivity(), "Ha ocurrido Un Error Intentelo Mas tarde", Toast.LENGTH_LONG).show();
        }else if (imagen1 == "null" && imagen2 == "null" && imagen3 =="null"){
            Toast.makeText(getActivity(), "debes seleccionar una imagen", Toast.LENGTH_LONG).show();
        }else if (imagen1 == "null" || imagen2 == "null" || imagen3 =="null"){
            //Convertir bits a cadena
            if (imagen1 == "true"){
                imagen1 = getStringImagen(bitmap1);
            }
            if (imagen2 == "true"){
                imagen2 = getStringImagen(bitmap2);
            }
            if (imagen3 == "true"){
                imagen3 = getStringImagen(bitmap3);
            }
            GuardarNegocio();
        }else if (imagen1 == "true" && imagen2 == "true" && imagen3 == "true"){
            imagen1 = getStringImagen(bitmap1);
            imagen2 = getStringImagen(bitmap2);
            imagen3 = getStringImagen(bitmap3);
            Log.d("imagen 1 ", imagen1);
            Log.d("imagen 2 ", imagen2);
            Log.d("imagen 3 ", imagen3);
            GuardarNegocio();
        }
    }
    public String getStringImagen(Bitmap bmp){
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        bmp.compress(Bitmap.CompressFormat.JPEG, 100, baos);
        byte[] imageBytes = baos.toByteArray();
        String encodedImage = Base64.encodeToString(imageBytes, Base64.DEFAULT);
        return encodedImage;
    }
    private void GuardarNegocio(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(getContext(),"Guardando Negocio...","Espere por favor...",false,false);
        //mProgress.show();
        StringRequest stringRequest = new StringRequest(Request.Method.POST, UPLOAD_URL + "/consultasdbNegocios/RegistroNegocios.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //Descartar el diálogo de progreso
                        loading.dismiss();
                        //mProgress.dismiss();
                        //Mostrando el mensaje de la respuesta
                        Toast.makeText(getActivity(), s , Toast.LENGTH_LONG).show();
                        textViewError.setText(s);
                        Tab1.NombreNego.setText("");
                        Tab1.DescripcionNego.setText("");
                        Tab1.DireccionNego.setText("");
                        Tab1.HorarioNego.setText("");
                        Tab1.TelFNego.setText("");
                        Tab1.TelMNego.setText("");
                        Tab2.CorreoNego.setText("");
                        Tab2.SitioNego.setText("");
                        Tab2.faceNego.setText("");
                        Tab2.TuiwerNego.setText("");
                        Tab2.InstagramNego.setText("");
                        Tab2.OtraRNego.setText("");
                        Tab2.TagsNego.setText("");
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Descartar el diálogo de progreso
                        //loading.dismiss();
                        mProgress.dismiss();
                        //Showing toast
                        textViewError.setText(volleyError.getMessage().toString());
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                    //Agregando de parámetros
                    params.put(KEY_IMAGEN1, imagen1);
                    params.put(KEY_IMAGEN2, imagen2);
                    params.put(KEY_IMAGEN3, imagen3);
                    params.put(IdUsuario,idusuario);
                    params.put(Nombre_Negocio , nombrenegocio);
                    params.put(Descripcion , descripcion);
                    params.put(Direccion_N , direccion);
                    params.put(Horario ,horario);
                    params.put(Telefono_F , telefonof);
                    params.put(Telefono_M , telefonom);
                    params.put(IdCategoria , idcategoria);
                    params.put(Email_N , emailnegocio);
                    params.put(Sitio_Web ,sitioweb);
                    params.put(Facebook ,facebook);
                    params.put(Twitter , twitter);
                    params.put(Instagram , instagram);
                    params.put(Otra_Red , otrared);
                    params.put(Tags , tags);
                    params.put(Posicion_GPS, posicion_gps);
                    //Parámetros de retorno
                    return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(getActivity().getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }
    private void OpenGaleria() {
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        startActivityForResult(Intent.createChooser(intent, "Select Imagen"), PICK_IMAGE_REQUEST);
    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == PICK_IMAGE_REQUEST && resultCode == Activity.RESULT_OK && data != null && data.getData() != null) {
            Uri filePath = data.getData();
            try {
                if (valor == 1){
                    //Cómo obtener el mapa de bits de la Galería
                    bitmap1 = MediaStore.Images.Media.getBitmap(getActivity().getContentResolver(), filePath);
                    //Configuración del mapa de bits en ImageView
                    img1.setImageBitmap(bitmap1);
                    //Valor para activar imagen 1
                    imagen1 = "true";
                }else if (valor == 2){
                    //Cómo obtener el mapa de bits de la Galería
                    bitmap2 = MediaStore.Images.Media.getBitmap(getActivity().getContentResolver(), filePath);
                    //Configuración del mapa de bits en ImageView
                    img2.setImageBitmap(bitmap2);
                    //Valor para activar imagen 1
                    imagen2 = "true";
                }else if (valor == 3){
                    //Cómo obtener el mapa de bits de la Galería
                    bitmap3 = MediaStore.Images.Media.getBitmap(getActivity().getContentResolver(), filePath);
                    //Configuración del mapa de bits en ImageView
                    //img3.setImageBitmap(bitmap3);
                    img3.setImageBitmap(bitmap3);
                    //Valor para activar imagen 1
                    imagen3 = "true";
                }
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }
}