package com.example.deadshot.elbisne;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.TextInputEditText;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.helper.ItemTouchHelper;
import android.telecom.TelecomManager;
import android.util.Log;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

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
import java.util.ArrayList;
import java.util.List;

public class AyudaFragment extends Fragment {

    private List<Contacto> contactos;
    private RecyclerView listaContactos;
    private AdaptadorContactos adaptador;
    public static String RutaLocal= "http://10.0.2.2";
    public static String RutaWeb="http://www.elbisne.xolotlcl.com";
    String Ruta = MainActivity.RutaWeb;
    TextView lbltitulo;
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;

    /*VARIABLES DEL fRAGMENTO*/
    public TextInputEditText IdC,NombreC,CorreoC,Tel1C,Tel2C,UrlC;
    String id,nombre,correo,tel1,tel2,url;

    public AyudaFragment() {
        // Required empty public constructor
    }

    public static AyudaFragment newInstance(String param1, String param2) {
        AyudaFragment fragment = new AyudaFragment();
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
        View rootView = inflater.inflate(R.layout.fragment_ayuda, container, false);

        listaContactos=(RecyclerView)rootView.findViewById(R.id.recyclerContactos);
        LinearLayoutManager lim = new LinearLayoutManager(getActivity());
        lim.setOrientation(LinearLayoutManager.VERTICAL);
        listaContactos.setLayoutManager(lim);

        lbltitulo = (TextView)rootView.findViewById(R.id.lbltitulo);

        /*INSTANCIA PARA CARGAR EVENTOS AL TOCAR UN CARD VIEW*/
        /*ItemTouchHelper itemTouchHelper = new ItemTouchHelper(createHelperCallback());
        itemTouchHelper.attachToRecyclerView(listaContactos);*/

        CargarAyuda();

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

    private void inicializaAdaptador() {
        adaptador = new AdaptadorContactos(contactos);
        listaContactos.setAdapter(adaptador);
    }

    public void CargarAyuda(){
        new CargarDatosAyuda().execute(Ruta + "/consultasdbNegocios/GetContactos.php");

    }//END Cargar Datos deAyuda

    /* METODO PARA cARGAR LOS DATOS DE AYUDA*/
    private class CargarDatosAyuda extends AsyncTask<String, Void, String> {
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
            contactos = new ArrayList<>();
            //contactos.add(new Contacto("Biritha Angeles Gonzalez","7711545296","biritaangeles@gmail.com"));
            String nombre,telefono,correo;
            try {
                ja = new JSONArray(result);
                if (ja.getString(0).toString().trim().equals("Ha Ocurrido Un Error Intentelo Mas Tarde")){
                    lbltitulo.setText(R.string.tituloayuda);
                    Toast.makeText(getActivity(), "Error Al Cargar Datos", Toast.LENGTH_LONG).show();
                }else {
                    lbltitulo.setText(R.string.tituloayuda);
                    for (int i = 0; i <ja.length(); i++) {
                        JSONObject row = ja.getJSONObject(i);
                        nombre = row.getString("nombre").toString();
                        telefono = row.getString("telefono").toString();
                        correo = row.getString("correo").toString();
                        //Toast.makeText(getActivity(),"name: " + nombre + " phone: " + telefono + "mail: " + correo, Toast.LENGTH_LONG).show();
                        contactos.add(new Contacto(nombre.toString(),telefono.toString(),correo.toString()));
                    }
                    inicializaAdaptador();
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
    /*END METODOS PARA CARGAR ,AYUDA DEL USUARIO*/

    /*Metodo para determinar al hacer touch sobre un Cardview*/
    private ItemTouchHelper.Callback createHelperCallback(){
        ItemTouchHelper.SimpleCallback simpleItemTouchCallback =
                new ItemTouchHelper.SimpleCallback(ItemTouchHelper.UP | ItemTouchHelper.DOWN,
                        ItemTouchHelper.LEFT | ItemTouchHelper.RIGHT){

                    @Override
                    public boolean onMove(RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder, RecyclerView.ViewHolder target) {
                        moveItem(viewHolder.getAdapterPosition(),target.getAdapterPosition());
                        return false;
                    }

                    @Override
                    public void onSwiped(RecyclerView.ViewHolder viewHolder, int direction) {
                        deleteItem(viewHolder.getAdapterPosition());
                    }
                };
        return simpleItemTouchCallback;
    }
    /*Metodo para mover el CardView Arriba / Abajo*/
    private void moveItem(int oldPos, int newPos){
        Contacto item = (Contacto) contactos.get(oldPos);
        contactos.remove(oldPos);
        contactos.add(newPos, item);
        adaptador.notifyItemMoved(oldPos, newPos);
    }
    /*Metodo para Eliminar un CardView al Deslizar Izquierda / Derecha*/
    private void deleteItem(final int position){
        contactos.remove(position);
        adaptador.notifyItemRemoved(position);
    }

}