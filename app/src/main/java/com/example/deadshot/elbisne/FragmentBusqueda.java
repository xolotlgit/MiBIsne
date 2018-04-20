package com.example.deadshot.elbisne;

import android.app.ProgressDialog;
import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.miguelcatalan.materialsearchview.MaterialSearchView;

import java.util.ArrayList;
import java.util.Hashtable;
import java.util.List;
import java.util.Map;


public class FragmentBusqueda extends Fragment {

    /*Variables para Buscar NEgocios*/
    MaterialSearchView searchView;
    //ListView lstView;
    String UPLOAD_URL = MainActivity.RutaWeb;
    String ValorBusqueda ="";
    private String SEACH_NAME = "SearchName";

    public TextView lblMensaje;
    private List<SearchNegocio> searchNegocios;
    private RecyclerView listaNegocios;
    private AdaptadorSearchNegocios adaptador;
    /*END Variables para Buscar NEgocios*/

    /*limpiar*/
    private RecyclerView listaAnuncios;
    private List<Anuncio> anuncios;
    /*END limpiar*/

    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private String mParam1;
    private String mParam2;
    private OnFragmentInteractionListener mListener;
    public FragmentBusqueda() {
    }
    public static FragmentBusqueda newInstance(String param1, String param2) {
        FragmentBusqueda fragment = new FragmentBusqueda();
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
        View view = inflater.inflate(R.layout.fragment_busqueda, container, false);


        //Datos Del Bundle
        ValorBusqueda = MainActivity.ValorBusqueda;
        //recyclerNegocios
        listaNegocios=(RecyclerView)view.findViewById(R.id.recyclerBusqueda);
        LinearLayoutManager lim = new LinearLayoutManager(getActivity());
        lim.setOrientation(LinearLayoutManager.VERTICAL);
        listaNegocios.setLayoutManager(lim);

        CargarSearchNegocios();
        return view;
    }

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
        void onFragmentInteraction(Uri uri);
    }

    /*MEtodos para Cargar Negocios*/
    private void inicializaAdaptador() {
        adaptador = new AdaptadorSearchNegocios(searchNegocios);
        listaNegocios.setAdapter(adaptador);
    }
    public boolean onCreateOptionsMenu(Menu menu) {
        //getMenuInflater().inflate(R.menu.main,menu);
        MenuItem item = menu.findItem(R.id.action_search);
        item.setTitle("Buscar Negocio");
        searchView.setMenuItem(item);
        return true;
    }

    /*END Metodos para cargar negocios*/
    private void CargarSearchNegocios(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(getContext(),"Cargando Busqueda...","Espere por favor...",false,false);
        StringRequest stringRequest = new StringRequest(Request.Method.POST, UPLOAD_URL + "/consultasdbNegocios/SearchNegocios.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //Descartar el diálogo de progreso
                        //instancia del array list de anuncios
                        searchNegocios = new ArrayList<>();
                        //Variables para Agregar nuevo elemento al ArrayList
                        String id = "";
                        String nombre = "";
                        String descripcion = "";
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
                                //Arreglo para separar cada elemento del Registro, id,nombre, fecha, Url
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
                                    }
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
                                    }
                                    if (b == 2){
                                        String val3 = Contenido[b];
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val3.length();
                                        String extraerp = val3.substring(0,1);
                                        String extraeru = val3.substring(val3.length()-1);
                                        String remplazado=val3.replace(extraerp,"");
                                        String val1final3=remplazado.replace(extraeru, "");
                                        //Asignacion del Valor limpio a la variable global para guardar en el ArrayList
                                        descripcion=val1final3;
                                    }
                                    if (b == 3){
                                        String val4 = Contenido[b];
                                        //Elimina las "" de cada registro dejando solo el dato String
                                        int cadena1 = val4.length();
                                        String extraerp = val4.substring(0,1);
                                        String extraeru = val4.substring(val4.length()-1);
                                        String remplazado=val4.replace(extraerp,"");
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
                                        searchNegocios.add(new SearchNegocio(id,nombre,descripcion,Url));
                                    }//End if 4
                                }//End del Recorrido de Arreglo Contenido por cada Row
                            }//End Elimina ]
                        }//End Elimina [
                        //Inicializa el Adaptador del RecyclerView con los datos del ArrayList de Anunucios
                        inicializaAdaptador();
                        //Oculta AlertDialog
                        loading.dismiss();
                        inicializaAdaptador();
                        loading.dismiss();
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Descartar el diálogo de progreso
                        loading.dismiss();
                        //Showing toast
                        Toast.makeText(getActivity(), volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(SEACH_NAME, MainActivity.ValorBusqueda);
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
