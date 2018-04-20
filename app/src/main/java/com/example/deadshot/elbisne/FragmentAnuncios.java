package com.example.deadshot.elbisne;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Interpolator;
import android.media.AsyncPlayer;
import android.net.Uri;
import android.nfc.Tag;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.AnimationUtils;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.JsonObjectRequest;
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
import java.text.DateFormat;
import java.text.DateFormatSymbols;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.Hashtable;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.regex.Pattern;


public class FragmentAnuncios extends Fragment {
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private String mParam1;
    private String mParam2;
    private OnFragmentInteractionListener mListener;

    private List<Anuncio> anuncios;
    private RecyclerView listaAnuncios;
    private AdaptadorAnuncios adaptador;
    public static String RutaLocal= "http://10.0.2.2";
    public static String RutaWeb="http://www.elbisne.xolotlcl.com";
    //Ruta del servidor Web
    String Ruta = MainActivity.RutaWeb;


    public FragmentAnuncios() {
        // Required empty public constructor
    }
    public static FragmentAnuncios newInstance(String param1, String param2) {
        FragmentAnuncios fragment = new FragmentAnuncios();
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
        // Inflate the layout for this fragment
        //return inflater.inflate(R.layout.fragment_anuncios, container, false);

        View view = inflater.inflate(R.layout.fragment_anuncios, container, false);

        listaAnuncios = ( RecyclerView)view.findViewById(R.id.recyclerAnuncios);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(getActivity());
        linearLayoutManager.setOrientation(LinearLayoutManager.VERTICAL);
        listaAnuncios.setLayoutManager(linearLayoutManager);

        FloatingActionButton floatingActionButton = (FloatingActionButton)view.findViewById(R.id.fab);
        floatingActionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                CargarAnuncios();
            }
        });

        CargarAnuncios();
        return view;
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

    private void inicializaAdaptador(){
        adaptador = new AdaptadorAnuncios(anuncios);
        listaAnuncios.setAdapter(adaptador);
    }

    private String CargarAnuncios(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(getContext(),"Cargando Anuncios...","Espere por favor...",false,false);

        StringRequest stringRequest = new StringRequest(Request.Method.POST, Ruta + "/consultasdbNegocios/GetAnuncios.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //mensaje.setText(s);
                        int values =0;
                        //Log.d("onResponse: ", s);
                        //instancia del array list de anuncios
                        anuncios = new ArrayList<>();
                        //Variables para Agregar nuevo elemento al ArrayList
                        String id = "";
                        String nombre = "";
                        String fechIni = "";
                        String fechFin = "";
                        String Url = "";
                        //Arreglo donde guardara cada registro de anuncios
                        String[] Contenido;
                        //Arreglo donde guarda el registro sin [ y recorrido para cada uno
                        String arreglo[]=s.split("\\[");
                        for (int x=0; x<arreglo.length;x++){
                            //Log.d("Valor1 " + x , arreglo[x]);
                            //Arreglo donde guarda los nuevos registros sin ] y recorrido para cada uno
                            String arreglo2[] = arreglo[x].split("\\]");
                            for (int a=0; a<arreglo2.length; a++){
                                //Log.d("Valor2 " + x , arreglo2[a]);
                                String ValorActual = arreglo2[a];
                                Contenido = ValorActual.split(",(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)", -1);
                                //Recorrido de cada elemento de la Row
                                for (int b=0; b<Contenido.length; b++){
                                    //Validaaciones para determinar la pocicion actual de cada valor
                                    if (b == 0){
                                        String val1 = Contenido[b];
                                        String remplazado=val1.replace(val1,"");
                                        String val1final1=remplazado.replace(remplazado, "");
                                        id=val1;
                                    }//End if 0
                                    if (b == 1){
                                        String val2 = Contenido[b];
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val2.length();
                                        String extraerp = val2.substring(0,1);
                                        String extraeru = val2.substring(val2.length()-1);
                                        String remplazado=val2.replace(extraerp,"");
                                        String val1final2=remplazado.replace(extraeru, "");
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        nombre=val1final2;
                                    }//End if 1
                                    if (b == 2){
                                        String val3 = Contenido[b];
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val3.length();
                                        String extraerp = val3.substring(0,1);
                                        String extraeru = val3.substring(val3.length()-1);
                                        String remplazado=val3.replace(extraerp,"");
                                        String val1final3=remplazado.replace(extraeru, "");
                                        //Log.d("valor final3 ",val1final3);
                                        //Convertir Fechas
                                        String sepfechas[] = val1final3.split("\\-");
                                        int valormes = Integer.parseInt(sepfechas[1]);
                                        int valordia = Integer.parseInt(sepfechas[2]);

                                        SimpleDateFormat formatter = new SimpleDateFormat("MMMM", new Locale("es", "MX"));
                                        GregorianCalendar calendar = new GregorianCalendar();
                                        calendar.set(Calendar.DAY_OF_MONTH, valordia);
                                        calendar.set(Calendar.MONTH, valormes-1);
                                        String DateEndOfWeek = calendar.getDisplayName(Calendar.DAY_OF_WEEK, Calendar.LONG,  new Locale("es", "MX")).toLowerCase();
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        fechIni = DateEndOfWeek + " " + sepfechas[2] + " de " + formatter.format(calendar.getTime()) + " del " + sepfechas[0];
                                    }//End if 2
                                    if (b == 3){
                                        String val4 = Contenido[b];
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val4.length();
                                        String extraerp = val4.substring(0,1);
                                        String extraeru = val4.substring(val4.length()-1);
                                        String remplazado=val4.replace(extraerp,"");
                                        String val1final4=remplazado.replace(extraeru, "");
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
                                        fechFin = DateEndOfWeek + " " + sepfechas[2] + " de " + formatter.format(calendar.getTime()) + " del " + sepfechas[0];
                                    }//End if 3
                                    if (b == 4){
                                        String val5 = Contenido[b];
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val5.length();
                                        String extraerp = val5.substring(0,1);
                                        String extraeru = val5.substring(val5.length()-1);
                                        String remplazado=val5.replace(extraerp,"");
                                        String urloriginal=remplazado.replace(extraeru, "");
                                        //Elimina todas las  Diagonales \\ de la direccion URL que causan error
                                        String arrayoriginal[]=urloriginal.split("\\\\");
                                        String newUrl = "";
                                        //Ciclo para ajustar el valor de la URL a un valor reconocido por Glide
                                        for (int i =0; i<arrayoriginal.length; i++){
                                            newUrl += arrayoriginal[i];
                                        }
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        Url=newUrl;
                                        //Agrega el registro actual al ArrayList del anuncio
                                        anuncios.add(new Anuncio(id,nombre,fechIni,fechFin,Url));
                                        //Log.d("Valor Actual Enviado id ",id+ " nombre " + nombre+ "fecha Ini " + fechIni+ " Fech Fin " + fechFin+ " URL "+Url);
                                    }//End if 4
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
                        Log.d("Erro Vollet: ", volleyError.getMessage().toString());
                        Toast.makeText(getActivity(), volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                    }
                }){
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(getActivity().getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);

        return "Success";
    }
}
