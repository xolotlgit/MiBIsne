package com.example.deadshot.elbisne;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.Hashtable;
import java.util.Map;

public class ActivityRegistroGoogle extends AppCompatActivity {

    //Campos dentro de ActivityRegistroGoogle.xml
    public EditText nombreusuario,apellidos,direccion,tel1,tel2,correo,alias,contrasena,contrasenaconf;
    public Button mRegisterButton,Cancelar,btnGuardarUser,btnCancelarReg;
    String telefono1, telefono2;
    //Rutas del Servidor local y web
    private String UPLOAD_URLLocal ="http://10.0.2.2/";
    public static String UPLOAD_URL="http://www.elbisne.xolotlcl.com/";
    //Variables con valor para enviar por POST
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
    //Variables de Bundle
    String email, displayName;
    private ProgressDialog mProgress;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_registro_google);

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

        email ="";
        displayName = "";
        Bundle extras = getIntent().getExtras();
        if (extras != null){
            displayName = extras.getString("displayName");
            email = extras.getString("email");
            String nombrecompleto= displayName;
            String cadena[] = nombrecompleto.split("(?=\\s)");
            if (cadena.length == 3){
                nombreusuario.setText(cadena[0]);
                apellidos.setText(cadena[1].trim() + " " + cadena[2]);
                alias.setText(cadena[0] + " " + cadena[1]);
            }else if (cadena.length > 3){
                nombreusuario.setText(cadena[0] + " " +cadena[1]);
                alias.setText(cadena[0] + " " +cadena[1]);
                String app="";
                for (int i = 2; i<cadena.length;i++){
                    app += cadena[i] + " ";
                }
                apellidos.setText(app);
            }else if (cadena.length < 3){
                nombreusuario.setText(displayName);
                alias.setText(displayName);
            }
            correo.setText(email);
        }else {
            Toast.makeText(ActivityRegistroGoogle.this,"Ha ocurrido un error al obtener los datos de la cuenta de Google",Toast.LENGTH_LONG).show();
            finish();
        }

        //Dialog de progreso
        mProgress = new ProgressDialog(this);
        //Listener  del Boton registro
        btnGuardarUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GuardarUsuario();
            }
        });//END Listener  del Boton registro

        btnCancelarReg.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AlertDialog alertDialog = new AlertDialog.Builder(ActivityRegistroGoogle.this).create();
                alertDialog.setTitle("Advertencia!!");
                alertDialog.setMessage("No se guardarán datos. ¿Desea continuar?");
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
                                ActivityInicioSesion.valorActual = 0;
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
            Toast.makeText(this, "Existen campos vacíos", Toast.LENGTH_LONG).show();
            return false;
        }
        if (tel1.getText().toString().trim().equals("") && tel2.getText().toString().trim().equals("")){
            Toast.makeText(this, "Debes tener al menos un teléfono", Toast.LENGTH_LONG).show();
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
            Toast.makeText(this, "Las contraseñas no coinciden", Toast.LENGTH_LONG).show();
            return false;
        }
    }
    //END de la Validacion de datos

    /*Guardar Datos del usuarion en db MySQL*/
    public void GuardarUsuario(){
        //Mostrar el diálogo de progreso
        final ProgressDialog loading = ProgressDialog.show(ActivityRegistroGoogle.this,"Guardando datos...","Espere por favor...",false,false);
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
                        //Toast.makeText(ActivityRegistroGoogle.this, s , Toast.LENGTH_LONG).show();
                        Intent intent = new Intent(ActivityRegistroGoogle.this, MainActivity.class);
                        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                        startActivity(intent);
                        overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError volleyError) {
                        //Descartar el diálogo de progreso
                        //loading.dismiss();
                        mProgress.dismiss();
                        //Showing toast
                        Toast.makeText(ActivityRegistroGoogle.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
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
        RequestQueue requestQueue = Volley.newRequestQueue(ActivityRegistroGoogle.this);
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
                    .setMessage("¿Seguro que desea salir?")
                    .setNegativeButton(android.R.string.cancel, null)// sin listener
                    .setPositiveButton(android.R.string.ok, new DialogInterface.OnClickListener() {// un listener que al pulsar, cierre la aplicacion
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            ActivityRegistroGoogle.this.finish();
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
