package com.example.deadshot.elbisne;

import android.*;
import android.Manifest;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.provider.Settings;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.JsonReader;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.sql.Date;
import java.util.ArrayList;
import java.util.Hashtable;
import java.util.List;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONStringer;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

public class ActivityRegistroUser extends AppCompatActivity {

    public EditText nombreusuario,apellidos,direccion,tel1,tel2,correo,alias,contrasena,contrasenaconf;
    public Button mRegisterButton,Cancelar,btnGuardarUser,btnCancelarReg;
    String telefono1, telefono2;

    private FirebaseAuth mAuth;
    private ProgressDialog mProgress;
    private FirebaseAuth.AuthStateListener mAuthListener;

    private String UPLOAD_URLLocal ="http://10.0.2.2/";
    public static String UPLOAD_URL="http://www.elbisne.xolotlcl.com/";
    private String NAME_USER = "Nombre_User";
    private String APELLIDOS = "Apellidos";
    private String DIRECCION = "Direccion";
    private String TELEFONO1 = "Telefono1";
    private String TELEFONO2 = "Telefono2";
    private String POSICION_GPS ="Posicion_GPS";
    private String ALIAS = "Alias_Usuario";
    private String CORREO = "email";
    private String CONTRASEÑA = "password";

    //Variables para localizacion del usuario
    LocationManager locationManager;
    double longitudeBest, latitudeBest;
    String PosicionGps ="Longitud: -98.75913109999999" + "_" + "Latitud: 20.1010608";

    @Override
    protected void onStart() {
        super.onStart();
        mAuth.addAuthStateListener(mAuthListener);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_user);
        //Indicializacion del servicio de ubicacion
        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);

        //Indicializar EditText y botones del layoud
        nombreusuario = (EditText)findViewById(R.id.txtNombreCompleto);
        apellidos = (EditText)findViewById(R.id.txtApellidos);
        direccion = (EditText)findViewById(R.id.txtDireccion);
        tel1 = (EditText)findViewById(R.id.txtTel1);
        telefono1 = tel1.getText().toString().trim();
        tel2 = (EditText)findViewById(R.id.txtTel2);
        telefono2 = tel2.getText().toString().trim();
        alias = (EditText)findViewById(R.id.txtAlias);
        correo =(EditText)findViewById(R.id.txtCorreoUser);
        contrasena = (EditText)findViewById(R.id.txtContrasena);
        contrasenaconf = (EditText)findViewById(R.id.txtContrasenaConf);
        //mRegisterButton = (Button)findViewById(R.id.btnGuardar);
        btnCancelarReg = (Button)findViewById(R.id.btnCancelarReg);
        btnGuardarUser = (Button)findViewById(R.id.btnGuardarUser);

        //Instancia del Auth
        mAuth = FirebaseAuth.getInstance();
        //Dialog de progreso
        mProgress = new ProgressDialog(this);
        //Listener  del Boton registro
        btnGuardarUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startRegister();
            }
        });//END Listener  del Boton registro
        //Listener de Auth  en FireBase
        mAuthListener = new FirebaseAuth.AuthStateListener() {
            @Override
            public void onAuthStateChanged(@NonNull FirebaseAuth firebaseAuth) {
                if (firebaseAuth.getCurrentUser() != null) {
                    Intent intent = new Intent(ActivityRegistroUser.this, MainActivity.class);
                    startActivity(intent);
                    finish();
                }
            }
        };//End Listener de Auth  en FireBase
        //Listener de Botones
        btnCancelarReg.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog alertDialog = new AlertDialog.Builder(ActivityRegistroUser.this).create();
                alertDialog.setTitle("Advertencia !!");
                alertDialog.setMessage("No se Guardaran Datos. ¿Desea Continuar?");
                alertDialog.setButton(AlertDialog.BUTTON_NEGATIVE, "No",
                        new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                dialog.dismiss();
                            }
                        });
                alertDialog.setButton(AlertDialog.BUTTON_NEUTRAL, "Si",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int which) {
                                Intent intent =new Intent(getApplicationContext(),ActivityInicioSesion.class);
                                startActivity(intent);
                                overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
                                finish();
                            }
                        });
                alertDialog.show();
            }
        });
        //END Listner Botones
        //Inicion de Ubicacion
        GetLocGPS();
    }

    //Registro de Usuarios En FireBAse
    private void startRegister() {
        final String name = nombreusuario.getText().toString().trim();
        final String email = correo.getText().toString().trim();
        final String password = contrasena.getText().toString().trim();

        if (Validacion() && !TextUtils.isEmpty(name) && !TextUtils.isEmpty(email) && !TextUtils.isEmpty(password)) {
            mProgress.setMessage("Registrando, Espere...");
            mProgress.show();
            mAuth.createUserWithEmailAndPassword(email, password)
                    .addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                        @Override
                        public void onComplete(@NonNull Task<AuthResult> task) {
                            if (Validacion()){
                                GuardarUsuario();
                                mProgress.dismiss();
                                if (task.isSuccessful()) {
                                    mAuth.signInWithEmailAndPassword(email, password);
                                    Intent intent =new Intent(getApplicationContext(),MainActivity.class);
                                    startActivity(intent);
                                    overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
                                    finish();
                                } else{
                                    Toast.makeText(ActivityRegistroUser.this, "El correo ya se encuentra registrado", Toast.LENGTH_SHORT).show();
                                }
                            }
                        }
                    });
        }
    }//END Metodo Registrar usuario FireBase

    //Validacion de Datos del Registro de Usuarios en DB MySQL
    public boolean Validacion(){
        //Toast.makeText(getApplicationContext(), PosicionGps,Toast.LENGTH_LONG).show();
        if (nombreusuario.getText().toString().trim().equals("") ||
                apellidos.getText().toString().trim().equals("") ||
                direccion.getText().toString().trim().equals("") ||
                alias.getText().toString().trim().equals("") ||
                correo.getText().toString().trim().equals("") ||
                contrasena.getText().toString().trim().equals("") ||
                contrasenaconf.getText().toString().trim().equals("")){
            Toast.makeText(getApplicationContext(), "Existen Campos Vacios", Toast.LENGTH_LONG).show();
            return false;
        }
        if (tel1.getText().toString().trim().equals("") && tel2.getText().toString().trim().equals("")){
            Toast.makeText(getApplicationContext(), "Debes Tener Alenos un Telefono", Toast.LENGTH_LONG).show();
            return false;
        }
        if (tel1.getText().toString().trim().equals("") || tel2.getText().toString().trim().equals("")){
            if (tel1.getText().toString().trim().equals("")){
                telefono1 = "0";
            }if (tel2.getText().toString().trim().equals("")){
                telefono2 = "0";
            }
        }
        if (contrasena.getText().toString().trim().equals(contrasenaconf.getText().toString().trim())){
            //Aqui Codigo
            return true;
        }else {
            Toast.makeText(getApplicationContext(), "Las Contraseñas No Coinciden", Toast.LENGTH_LONG).show();
            return false;
        }
    }
    //END de la Validacion de datos

    /*Guardar Datos del usuarion en db MySQL*/
    public void GuardarUsuario(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(ActivityRegistroUser.this,"Guardado Datos...","Espere por favor...",false,false);
        //mProgress.show();
        StringRequest stringRequest = new StringRequest(Request.Method.POST, UPLOAD_URL + "/consultasdbNegocios/RegistroUsuarios.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        //Descartar el diálogo de progreso
                        loading.dismiss();
                        mProgress.dismiss();
                        Log.d("OnResponse ",s);
                        //Mostrando el mensaje de la respuesta
                        //Toast.makeText(ActivityRegistroUser.this, s , Toast.LENGTH_LONG).show();
                        Log.d("onResponse", s);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Descartar el diálogo de progreso
                        //loading.dismiss();
                        mProgress.dismiss();
                        //Showing toast
                        Toast.makeText(ActivityRegistroUser.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                        Log.d("Volley Error",volleyError.getMessage().toString());
                    }
                }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                //Creación de parámetros
                Map<String,String> params = new Hashtable<String, String>();
                //Agregando de parámetros
                params.put(NAME_USER, nombreusuario.getText().toString().trim());
                params.put(APELLIDOS, apellidos.getText().toString().trim());
                params.put(DIRECCION, direccion.getText().toString().trim());
                params.put(TELEFONO1,tel1.getText().toString().trim());
                params.put(TELEFONO2 , tel2.getText().toString().trim());
                params.put(POSICION_GPS , PosicionGps);
                params.put(ALIAS , alias.getText().toString().trim());
                params.put(CORREO ,correo.getText().toString().trim());
                params.put(CONTRASEÑA , contrasena.getText().toString().trim());
                //Parámetros de retorno
                return params;
            }
        };
        //Creación de una cola de solicitudes
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityRegistroUser.this);
        //Agregar solicitud a la cola
        requestQueue.add(stringRequest);
    }
    /*END Guardar Datos del usuarion en db MySQL*/

    //evento al presionar boton atras*/
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            new AlertDialog.Builder(this)
                    .setIcon(android.R.drawable.ic_dialog_alert)
                    .setTitle("Salir")
                    .setMessage("Seguro Que Desea Salir?")
                    .setNegativeButton(android.R.string.cancel, null)// sin listener
                    .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {// un listener que al pulsar, cierre la aplicacion
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            ActivityRegistroUser.this.finish();
                        }
                    }).show();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
    //END evento al presionar boton atras*/

    /*METODOS PARA OBTENER LA UBICACION DEL USUARIO*/
    private boolean checkLocation() {
        if (!isLocationEnabled())
            showAlert();
        return isLocationEnabled();
    }
    private void showAlert() {
        final AlertDialog.Builder dialog = new AlertDialog.Builder(this);
        dialog.setTitle("Activar Localizacion Location")
                .setMessage("Su ubicación esta desactivada.\npor favor active su ubicación para mejorar la experiencia del usuario")
                .setPositiveButton("Activar Ubicación", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface paramDialogInterface, int paramInt) {
                        Intent myIntent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
                        startActivity(myIntent);
                    }
                })
                .setNegativeButton("Cancelar", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface paramDialogInterface, int paramInt) {
                        PosicionGps ="Longitud: -98.75913109999999" + "_" + "Latitud: 20.1010608";
                    }
                });
        dialog.show();
    }
    private boolean isLocationEnabled() {
        return locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER) ||
                locationManager.isProviderEnabled(LocationManager.NETWORK_PROVIDER);
    }
    public void GetLocGPS() {
        if (!checkLocation()) {
            return;
        }
        if (ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

        }
        locationManager.removeUpdates(locationListenerBest);
        Criteria criteria = new Criteria();
        criteria.setAccuracy(Criteria.ACCURACY_FINE);
        criteria.setAltitudeRequired(false);
        criteria.setBearingRequired(false);
        criteria.setCostAllowed(true);
        criteria.setPowerRequirement(Criteria.POWER_LOW);
        String provider = locationManager.getBestProvider(criteria, true);
        if (provider != null) {
            locationManager.requestLocationUpdates(provider, 2 * 20 * 1000, 10, locationListenerBest);
        }

    }
    private final LocationListener locationListenerBest = new LocationListener() {
        public void onLocationChanged(Location location) {
            longitudeBest = location.getLongitude();
            latitudeBest = location.getLatitude();

            runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    //Toast.makeText(getApplicationContext(), "Longitud: " + longitudeBest + "Latitud: " + latitudeBest, Toast.LENGTH_SHORT).show();
                    PosicionGps ="Longitud: " + longitudeBest + "_" + "Latitud: " + latitudeBest;
                }
            });
        }

        @Override
        public void onStatusChanged(String s, int i, Bundle bundle) {
        }

        @Override
        public void onProviderEnabled(String s) {
        }

        @Override
        public void onProviderDisabled(String s) {
        }
    };
    /*END DE METODOS PARA OBTENER LA UBICACION DEL USUARIO*/

}
