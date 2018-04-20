package com.example.deadshot.elbisne;

import android.*;
import android.Manifest;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.Settings;
import android.support.design.widget.TextInputEditText;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.Fragment;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.Spinner;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;

public class Tab1 extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    public static Spinner CboxCategorias;//spinner Categorias
    public static Button btnSaveGeneral;//Boton del fragment 1
    //Textos del fragment 1
    public static TextInputEditText Iduser,NombreNego,DescripcionNego,DireccionNego,HorarioNego,TelFNego,TelMNego;
    //Varible para definir el tamaño de la consulta de categorias
    int size = 0;
    //Ruta del Servidor Web
    String Ruta = MainActivity.RutaWeb;

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;

    public Tab1() {
        // Required empty public constructor

    }

    // TODO: Rename and change types and number of parameters
    public static Tab1 newInstance(String param1, String param2) {
        Tab1 fragment = new Tab1();
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
        View rootView = inflater.inflate(R.layout.fragment_tab1, container, false);

        //Variables del Fragmetn de registro1
        CboxCategorias = (Spinner)rootView.findViewById(R.id.cboxCategoriasNego);
        Iduser = (TextInputEditText)rootView.findViewById(R.id.txtIdUsuarioNego);
        NombreNego = (TextInputEditText)rootView.findViewById(R.id.txtNombreNegocio);
        DescripcionNego = (TextInputEditText)rootView.findViewById(R.id.txtDescripcionNego);
        DireccionNego = (TextInputEditText)rootView.findViewById(R.id.txtDireccionNego);
        HorarioNego = (TextInputEditText)rootView.findViewById(R.id.txtHorarioNego);
        TelFNego = (TextInputEditText)rootView.findViewById(R.id.txtTelFNego);
        TelMNego = (TextInputEditText)rootView.findViewById(R.id.txtTelMNego);

        //Metodo para Cargar Categorias al Iniciar el Fragment
        ConsultaCategorias();
        Iduser.setText(FragmentRegistroNegocios.CorreoId);

        return rootView;
    }

    /*METODOS PRECARGADOS DEL FRAGMENT TAB 1*/
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
    /*METODOS DEL fRAGMENT 1*/

    /*METODOS PARA CARGAR Categorias DEL USUARIO*/
    //Metodo de Execute del la consulta
    private void ConsultaCategorias() {
        new CargarDatosCategorias().execute(Ruta + "/consultasdbNegocios/GetCategorias.php");
    }
    //Metodo que trae las Categorias
    private class CargarDatosCategorias extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... urls) {
            try {
                return downloadUrl(urls[0]);
            } catch (IOException e) {
                return "Unable to retrieve web page. URL may be invalid.";
            }
        }
        @Override
        protected void onPostExecute(String result) {
            JSONArray ja = null;
            try {
                ja = new JSONArray(result);

                //Validadcion de datos recividos
                if (ja.getString(0).toString().trim().equals("Ha Ocurrido Un Error Intentelo Mas Tarde")){
                    Toast.makeText(getActivity(), "Error Al Cargar Categorias Intentelo Mas tarde", Toast.LENGTH_LONG).show();
                }else {
                    //Recorrido del JSONArray para guardar los datos enun Arreglo
                    size = ja.length();
                    final String[] zona = new String[ja.length()];
                    for(int i=0; i<size; i++){
                        zona[i] = ja.getString(i);
                    }
                    //Llennar el Spinner con los datos del Arreglo y un Array Adpter
                    ArrayAdapter<String> adapter = new ArrayAdapter<String>(getContext(), android.R.layout.simple_spinner_item, zona);
                    adapter.setDropDownViewResource(android.R.layout.simple_dropdown_item_1line);
                    CboxCategorias.setAdapter(adapter);

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
        int len = 500;

        try {
            URL url = new URL(myurl);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            conn.setReadTimeout(10000 /* milliseconds */);
            conn.setConnectTimeout(15000 /* milliseconds */);
            conn.setRequestMethod("GET");
            conn.setDoInput(true);
            //inicia Consulta
            conn.connect();
            int response = conn.getResponseCode();
            Log.d("respuesta", "The response is: " + response);
            is = conn.getInputStream();


            String contentAsString = readIt(is, len);
            return contentAsString;

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
    /*END METODOS PARA CARGAR EL Guardar DEL USUARIO*/
}
