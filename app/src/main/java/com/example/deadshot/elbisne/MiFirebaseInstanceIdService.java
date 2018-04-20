package com.example.deadshot.elbisne;

import android.app.ProgressDialog;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

import java.util.ArrayList;
import java.util.Hashtable;
import java.util.Map;

public class MiFirebaseInstanceIdService extends FirebaseInstanceIdService {

    public static final String TAG = "NOTICIAS";
    String UPLOAD_URL = MainActivity.RutaWeb;
    public static String token;
    @Override
    public void onTokenRefresh() {
        super.onTokenRefresh();

        token = FirebaseInstanceId.getInstance().getToken();

        Log.d(TAG, "Token: " + token);
        enviarTokenAlServidor(token);
    }

    private void enviarTokenAlServidor(final String token) {
        // Enviar token al servidor
        StringRequest stringRequest = new StringRequest(Request.Method.POST, UPLOAD_URL +"/consultasdbNegocios/SetToken.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        Log.d("on response token",s);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                Log.d("token",token);
                Log.d("IdUsuario",MainActivity.emailActivo);
                params.put("token", token);
                params.put("IdUsuario", MainActivity.emailActivo);
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }
}
