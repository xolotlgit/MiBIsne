package com.example.deadshot.elbisne;

import android.app.ProgressDialog;
import android.content.Context;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.support.design.widget.TextInputEditText;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.app.AlertDialog;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.RotateAnimation;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.Hashtable;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class FragmentPerfil extends Fragment {

    private OnFragmentInteractionListener mListener;
    private ViewGroup linearLayoutDetails, layuoudcabecera2, layuoudcabecera, contenedordatos,contenedordatos2,contenedorsavecancel;
    private ImageView imageViewExpand;
    public Toolbar toolbar;
    private static final int DURATION = 250;
    //Variables que llegan con datos del usuario Logueado
    String emailuser,nombreuser,apellidosuser,direccionuser,tel1user,tel2user,aliasuser;
    int tambBundle =0;
    //Variables para el EditText del layud del perfiil de  usuario
    TextInputEditText nombre,direccion,tel1,tel2,correo,alias,nombre2,apellidos2,direccion2,tel12,tel22,correo2,alias2;
    //Boton de editar datos del perfil
    Button btnEditarDatosPerfil, btnGuardarDatosPerfil, btnCancelarDatosPerfil,btnStarRegistroNegocio;

    //Ruta del Servidor Web
    String Ruta = MainActivity.RutaWeb;

    //Variables para Negocios
    private List<UserNegocio> negocios;
    private RecyclerView listanegocios;
    private AdaptadorUserNegocios adaptador;
    int value =0;

    private String KEY_CORREO = "UserEmail";
    public String IdNegocio="";
    public FragmentPerfil() {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        //return inflater.inflate(R.layout.fragment_fragment_perfil, container, false);
        //ViewGroup root = (ViewGroup) inflater.inflate(R.layout.fragment_perfil, null);
        View rootView = inflater.inflate(R.layout.fragment_perfil, container, false);

        btnStarRegistroNegocio = (Button)rootView.findViewById(R.id.btnStarRegistroNegocio);
        CargarDatosPerfil();

        //Valor de los inputs del laoud del perfil de usuario
        correo =(TextInputEditText)rootView.findViewById(R.id.txtCorreoUser);
        nombre = (TextInputEditText)rootView.findViewById(R.id.txtnombreuser);
        direccion = (TextInputEditText)rootView.findViewById(R.id.txtDireccionUser);
        tel1 = (TextInputEditText)rootView.findViewById(R.id.txtTel1User);
        tel2 = (TextInputEditText)rootView.findViewById(R.id.txtTel2User);
        alias = (TextInputEditText)rootView.findViewById(R.id.txtAliasUser);
        btnEditarDatosPerfil = (Button)rootView.findViewById(R.id.btnEditarDatosPerfil);
        btnGuardarDatosPerfil = (Button)rootView.findViewById(R.id.btnGuardarDatosPerfil);
        btnCancelarDatosPerfil = (Button)rootView.findViewById(R.id.btnCancelarDatosPerfil);
        correo2 =(TextInputEditText)rootView.findViewById(R.id.txtCorreoUser2);
        nombre2 = (TextInputEditText)rootView.findViewById(R.id.txtnombreuser2);
        apellidos2 = (TextInputEditText)rootView.findViewById(R.id.txtapellidosuser2);
        direccion2 = (TextInputEditText)rootView.findViewById(R.id.txtDireccionUser2);
        tel12 = (TextInputEditText)rootView.findViewById(R.id.txtTel1User2);
        tel22 = (TextInputEditText)rootView.findViewById(R.id.txtTel2User2);
        alias2 = (TextInputEditText)rootView.findViewById(R.id.txtAliasUser2);
        //END Valor de los inputs del laoud del perfil de usuario

        //LAyouds contenedores de inputsEditText
        layuoudcabecera2 = (ViewGroup)rootView.findViewById(R.id.layuoudcabecera2);
        layuoudcabecera = (ViewGroup)rootView.findViewById(R.id.layuoudcabecera);
        contenedordatos = (ViewGroup)rootView.findViewById(R.id.contenedordatos);
        contenedordatos2  = (ViewGroup)rootView.findViewById(R.id.contenedordatos2);
        contenedorsavecancel = (ViewGroup)rootView.findViewById(R.id.contenedorsavecancel);

        //linear layud Detalles Usuario
        linearLayoutDetails = (ViewGroup)rootView.findViewById(R.id.linearLayoutDetails);
        //Imagen Usuario
        imageViewExpand = (ImageView)rootView.findViewById(R.id.imageViewExpand);

        //Listenr de expand Detalles
        LinearLayout btnDetallesUser = (LinearLayout)rootView.findViewById(R.id.btnDetallesUser);

        btnDetallesUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                DetallesUsuario();
            }
        });


        //BArra de titulo de Usuario
        Toolbar toolbarCard = (Toolbar)rootView.findViewById(R.id.toolbarCard);
        toolbarCard.setTitle(R.string.PerfilUsuario);

        //Listener del boton para editar Datos del usuario
        btnEditarDatosPerfil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                HabilitarCmaposTexto();

            }
        });//End del listener para editar los datos del usuario
        ///Listener del boton para Guardar los datos editados del perfil
        btnGuardarDatosPerfil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GuardarDatosPerfil();
            }
        });//End del Listener para guardar los datos editados del usuario
        //Listener del Boton para Cancelar el Editar Datos
        btnCancelarDatosPerfil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                DesabilitarCamposTexto();
            }
        });

        //Carga Listado de Negocios
        listanegocios = ( RecyclerView)rootView.findViewById(R.id.recyclerNegocios);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(getActivity());
        linearLayoutManager.setOrientation(LinearLayoutManager.VERTICAL);
        listanegocios.setLayoutManager(linearLayoutManager);

        negocios = new ArrayList<>();
        return rootView;
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

    //Metodo para Habilitar layoud para editar datos del usuario
    public void HabilitarCmaposTexto(){
        btnEditarDatosPerfil.setVisibility(View.GONE);
        btnGuardarDatosPerfil.setVisibility(View.VISIBLE);
        btnCancelarDatosPerfil.setVisibility(View.VISIBLE);
        layuoudcabecera2.setVisibility(View.VISIBLE);
        contenedordatos2.setVisibility(View.VISIBLE);
        layuoudcabecera.setVisibility(View.GONE);
        contenedordatos.setVisibility(View.GONE);
        contenedorsavecancel.setVisibility(View.VISIBLE);
    }
    //END Metodo para Habilitar layoud para editar datos del usuario

    //Metodo Para Mostrar los Datos del usuario Sin poder modificarlos
    public void DesabilitarCamposTexto(){
        btnGuardarDatosPerfil.setVisibility(View.GONE);
        btnCancelarDatosPerfil.setVisibility(View.GONE);
        btnEditarDatosPerfil.setVisibility(View.VISIBLE);
        layuoudcabecera2.setVisibility(View.GONE);
        contenedordatos2.setVisibility(View.GONE);
        layuoudcabecera.setVisibility(View.VISIBLE);
        contenedordatos.setVisibility(View.VISIBLE);
        contenedorsavecancel.setVisibility(View.GONE);
    }
    //END Metodo Para Mostrar los Datos del usuario Sin poder modificarlos

    public void GuardarDatosPerfil(){
        new CargarDatosUpdatePerfil().execute(Ruta + "/consultasdbNegocios/UpdateUser.php?Correo="+
                correo2.getText().toString()+
                "&Nombre="+nombre2.getText().toString().trim()+
                "&Apellidos="+apellidos2.getText().toString().trim()+
                "&Direccion="+direccion2.getText().toString().trim()+
                "&Telefono1="+tel12.getText().toString().trim()+
                "&Telefono2="+tel22.getText().toString().trim()+
                "&Alias_Usuario="+alias2.getText().toString().trim()
        );
    }

    /* METODO PARAActualizar los datos del perfil del usuario*/
    private class CargarDatosUpdatePerfil extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... urls) {

            // params comes from the execute() call: params[0] is the url.
            try {
                return downloadUrl(urls[0]);
            } catch (IOException e) {
                return "Unable to retrieve web page. URL may be invalid.";
            }
        }
        // onPostExecute displays the results of the AsyncTask.
        @Override
        protected void onPostExecute(String result) {
            JSONArray ja = null;
            try {
                ja = new JSONArray(result);
                if (ja.getString(0).toString().trim().equals("Ha Ocurrido Un Error Intentelo Mas Tarde")){
                    Toast.makeText(getActivity(), "Error Al Guardar Datos", Toast.LENGTH_LONG).show();
                }else {
                    Toast.makeText(getActivity(), "Datos Actualizados", Toast.LENGTH_LONG).show();
                    //Asignacion de Datos del Perfil a las Variables
                    nombre.setText(ja.getString(1) + " " + ja.getString(2));
                    direccion.setText(ja.getString(3));
                    tel1.setText(ja.getString(4));
                    tel2.setText(ja.getString(5));
                    alias.setText(ja.getString(6));
                    nombre2.setText(ja.getString(1));
                    apellidos2.setText(ja.getString(2));
                    direccion2.setText(ja.getString(3));
                    tel12.setText(ja.getString(4));
                    tel22.setText(ja.getString(5));
                    alias2.setText(ja.getString(6));
                    //END Asignacion de Datos del Perfil a las Variables
                    DesabilitarCamposTexto();
                }

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    private String downloadUrl(String myurl) throws IOException {
        Log.i("URL",""+myurl);
        myurl = myurl.replace(" ","%20");
        InputStream is = null;
        // Only display the first 500 characters of the retrieved
        // web page content.
        int len = 500;

        try {
            URL url = new URL(myurl);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setReadTimeout(10000 /* milliseconds */);
            conn.setConnectTimeout(15000 /* milliseconds */);
            conn.setRequestMethod("GET");
            conn.setDoInput(true);
            // Starts the query
            conn.connect();
            int response = conn.getResponseCode();
            Log.d("respuesta", "The response is: " + response);
            is = conn.getInputStream();

            // Convert the InputStream into a string
            String contentAsString = readIt(is, len);
            return contentAsString;

            // Makes sure that the InputStream is closed after the app is
            // finished using it.
        } finally {
            if (is != null) {
                is.close();
            }
        }
    }
    public String readIt(InputStream stream, int len) throws IOException, UnsupportedEncodingException {
        Reader reader = null;
        reader = new InputStreamReader(stream, "UTF-8");
        char[] buffer = new char[len];
        reader.read(buffer);
        return new String(buffer);
    }
    /*END METODO PARAActualizar los datos del perfil del usuario*/

    //Cambia Visibilidad para los detalles del usuario
    public void DetallesUsuario() {
        if (linearLayoutDetails.getVisibility() == View.GONE) {
            ExpandAndCollapseViewUtil.expand(linearLayoutDetails, DURATION);
            imageViewExpand.setImageResource(R.mipmap.more);
            rotateuser(-180.0f);
        } else {
            ExpandAndCollapseViewUtil.collapse(linearLayoutDetails, DURATION);
            imageViewExpand.setImageResource(R.mipmap.less);
            rotateuser(180.0f);
        }
    }

    /*Animaciones de rotamiento */
    private void rotateuser(float angle) {
        Animation animation = new RotateAnimation(0.0f, angle, Animation.RELATIVE_TO_SELF, 0.5f,
                Animation.RELATIVE_TO_SELF, 0.5f);
        animation.setFillAfter(true);
        animation.setDuration(DURATION);
        imageViewExpand.startAnimation(animation);
    }

    /*Indicializacion de Negocios*/
    private void inicializaAdaptador(){
        adaptador = new AdaptadorUserNegocios(negocios);
        listanegocios.setAdapter(adaptador);
    }

    /* Cargar Datos del Perfil*/
    private void CargarDatosPerfil(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(getContext(),"Cargando Perfil...","Espere por favor...",false,false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/GetPerfil.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //Log.d("On Response", s);
                        JSONArray ja = null;
                        try {
                            ja = new JSONArray(s);
                            if (ja.getString(0).toString().trim().equals("Ha Ocurrido Un Error Intentelo Mas Tarde")){
                                Toast.makeText(getActivity(), "Error Al Cargar Datos", Toast.LENGTH_LONG).show();
                            }else {
                                //Asignacion de Datos del Perfil a las Variables
                                correo.setText(MainActivity.emailActivo);
                                nombre.setText(ja.getString(0)+" "+ja.getString(1));
                                direccion.setText(ja.getString(2));
                                tel1.setText(ja.getString(3));
                                tel2.setText(ja.getString(4));
                                alias.setText(ja.getString(5));
                                correo2.setText(MainActivity.emailActivo);
                                nombre2.setText(ja.getString(0));
                                apellidos2.setText(ja.getString(1));
                                direccion2.setText(ja.getString(2));
                                tel12.setText(ja.getString(3));
                                tel22.setText(ja.getString(4));
                                alias2.setText(ja.getString(5));
                                //END Asignacion de Datos del Perfil a las Variables
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        loading.dismiss();
                        CargarDatosNegocios();
                    }//End OnResponse
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        Log.d("Erro Vollet: ", volleyError.getMessage());
                        Toast.makeText(getActivity(), volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(KEY_CORREO, MainActivity.emailActivo);
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(getActivity().getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }
    /*Cargar Negocios*/
    private void CargarDatosNegocios(){
        Log.d("Inidicio","CargarDatosNegocios");
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(getContext(),"Cargando Negocios...","Espere por favor...",false,false);

        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/GetNegociosUser.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //mensaje.setText(s);
                        int values =0;
                        Log.d("onResponse ", s);
                        //instancia del array list de anuncios
                        negocios = new ArrayList<>();
                        //Variables para Agregar nuevo elemento al ArrayList
                        String IdNegocio = "" ;
                        String Nombre_Negocio = "" ;
                        String Descripcion = "" ;
                        String Imagen1 = "" ;
                        String Fech_Ini_Suscrip = "" ;
                        String Fech_Fin_Suscrip = "" ;
                        //Arreglo donde guardara cada registro de anuncios
                        String[] Contenido;
                        //Arreglo donde guarda el registro sin [ y recorrido para cada uno
                        String arreglo[]=s.split("\\[");
                        for (int x=0; x<arreglo.length;x++){
                            Log.d("Valor1 " + x , arreglo[x]);
                            //Arreglo donde guarda los nuevos registros sin ] y recorrido para cada uno
                            String arreglo2[] = arreglo[x].split("\\]");
                            for (int a=0; a<arreglo2.length; a++){
                                Log.d("Valor2 " + x , arreglo2[a]);
                                String ValorActual = arreglo2[a];
                                Contenido = ValorActual.split(",(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)", -1);
                                //Recorrido de cada elemento de la Row
                                for (int b=0; b<Contenido.length; b++){
                                    //Validaaciones para determinar la pocicion actual de cada valor
                                    if (b == 0){
                                        String val1 = Contenido[b];
                                        String remplazado=val1.replace(val1,"");
                                        String val1final1=remplazado.replace(remplazado, "");
                                        Log.d("val1 ",val1);
                                        IdNegocio=val1;
                                    }//End if 0
                                    if (b == 1){
                                        String val2 = Contenido[b];
                                        Log.d("val2 ",val2);
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val2.length();
                                        String extraerp = val2.substring(0,1);
                                        String extraeru = val2.substring(val2.length()-1);
                                        String remplazado=val2.replace(extraerp,"");
                                        String val1final2=remplazado.replace(extraeru, "");
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        Nombre_Negocio=val1final2;
                                    }//End if 1
                                    if (b == 2){
                                        String val3 = Contenido[b];
                                        Log.d("val3 ",val3);
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val3.length();
                                        String extraerp = val3.substring(0,1);
                                        String extraeru = val3.substring(val3.length()-1);
                                        String remplazado=val3.replace(extraerp,"");
                                        String val1final3=remplazado.replace(extraeru, "");
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        Descripcion=val1final3;
                                    }//End if 2
                                    if (b == 3){
                                        String val4 = Contenido[b];
                                        Log.d("val4 ",val4);
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val4.length();
                                        String extraerp = val4.substring(0,1);
                                        String extraeru = val4.substring(val4.length()-1);
                                        String remplazado=val4.replace(extraerp,"");
                                        String val1final4=remplazado.replace(extraeru, "");
                                        Log.d("valor final3 ",val1final4);
                                        //Convertir Fechas
                                        String sepfechas[] = val1final4.split("\\-");
                                        int valormes = Integer.parseInt(sepfechas[1]);
                                        int valordia = Integer.parseInt(sepfechas[2]);

                                        SimpleDateFormat formatter = new SimpleDateFormat("MMMM", new Locale("es", "MX"));
                                        GregorianCalendar calendar = new GregorianCalendar();
                                        calendar.set(Calendar.DAY_OF_MONTH, valordia);
                                        calendar.set(Calendar.MONTH, valormes-1);
                                        String DateEndOfWeek = calendar.getDisplayName(Calendar.DAY_OF_WEEK, Calendar.LONG,  new Locale("es", "MX")).toLowerCase();
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        Fech_Ini_Suscrip = DateEndOfWeek + " " + sepfechas[2] + " de " + formatter.format(calendar.getTime()) + " del " + sepfechas[0];
                                    }//End if 3
                                    if (b == 4){
                                        String val5 = Contenido[b];
                                        Log.d("val5 ",val5);
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val5.length();
                                        String extraerp = val5.substring(0,1);
                                        String extraeru = val5.substring(val5.length()-1);
                                        String remplazado=val5.replace(extraerp,"");
                                        String val1final5=remplazado.replace(extraeru, "");
                                        //Convertir Fechas
                                        String sepfechas[] = val1final5.split("\\-");
                                        int valormes = Integer.parseInt(sepfechas[1]);
                                        int valordia = Integer.parseInt(sepfechas[2]);
                                        SimpleDateFormat formatter = new SimpleDateFormat("MMMM", new Locale("es", "MX"));
                                        GregorianCalendar calendar = new GregorianCalendar();
                                        calendar.set(Calendar.DAY_OF_MONTH, valordia);
                                        calendar.set(Calendar.MONTH, valormes-1);
                                        String DateEndOfWeek = calendar.getDisplayName(Calendar.DAY_OF_WEEK, Calendar.LONG,  new Locale("es", "MX")).toLowerCase();
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        Fech_Fin_Suscrip = DateEndOfWeek + " " + sepfechas[2] + " de " + formatter.format(calendar.getTime()) + " del " + sepfechas[0];
                                    }//End if 4
                                    if (b == 5){
                                        String val6 = Contenido[b];
                                        Log.d("val6 ",val6);
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val6.length();
                                        String extraerp = val6.substring(0,1);
                                        String extraeru = val6.substring(val6.length()-1);
                                        String remplazado=val6.replace(extraerp,"");
                                        String urloriginal=remplazado.replace(extraeru, "");
                                        //Elimina todas las  Diagonales \\ de la direccion URL que causan error
                                        String arrayoriginal[]=urloriginal.split("\\\\");
                                        String newUrl = "";
                                        //Ciclo para ajustar el valor de la URL a un valor reconocido por Glide
                                        for (int i =0; i<arrayoriginal.length; i++){
                                            newUrl += arrayoriginal[i];
                                        }
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        Imagen1=newUrl;
                                        //Agrega el registro actual al ArrayList del anuncio
                                        negocios.add(new UserNegocio(IdNegocio,Nombre_Negocio,Descripcion,Fech_Ini_Suscrip,Fech_Fin_Suscrip,Imagen1));
                                        Log.d("Valor Actual Enviado id ",IdNegocio+ " nombre " + Nombre_Negocio+ "fecha Ini " + Fech_Ini_Suscrip+ " Fech Fin " + Fech_Fin_Suscrip+ " URL "+Imagen1);
                                    }//End if 5
                                }//End del Recorrido de Arreglo Contenido por cada Row
                            }//End Elimina ]
                        }//End Elimina [
                        //Inicializa el Adaptador del RecyclerView con los datos del ArrayList de Anunucios
                        inicializaAdaptador();
                        //Oculta AlertDialog
                        loading.dismiss();
                    }//End OnResponse
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        Log.d("Erro Vollet: ", volleyError.getMessage());
                        Toast.makeText(getActivity(), volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(KEY_CORREO, MainActivity.emailActivo);
                Log.d("Valor correo enviado ",MainActivity.emailActivo);
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(getActivity().getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }
}
