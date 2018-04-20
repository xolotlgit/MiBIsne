package com.example.deadshot.elbisne;

import android.*;
import android.app.Dialog;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.Signature;
import android.graphics.Color;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.net.Uri;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;

import android.support.v4.view.ViewPager;
import android.support.v7.app.AlertDialog;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Base64;
import android.view.KeyEvent;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;

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
import com.facebook.AccessToken;
import com.facebook.login.LoginManager;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;

import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.auth.api.signin.GoogleSignInResult;
import com.google.android.gms.common.api.OptionalPendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.auth.GetTokenResult;
import com.miguelcatalan.materialsearchview.MaterialSearchView;

import android.os.AsyncTask;

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
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.Hashtable;
import java.util.List;
import java.util.Map;

import com.google.firebase.iid.FirebaseInstanceId;

public class MainActivity extends AppCompatActivity implements GoogleApiClient.OnConnectionFailedListener,
        NavigationView.OnNavigationItemSelectedListener, FragmentPerfil.OnFragmentInteractionListener,
        AyudaFragment.OnFragmentInteractionListener, FragmentAnuncios.OnFragmentInteractionListener,
        Tab1.OnFragmentInteractionListener, Tab2.OnFragmentInteractionListener, Tab3.OnFragmentInteractionListener,
        FragmentRegistroNegocios.OnFragmentInteractionListener, FragmentBusqueda.OnFragmentInteractionListener,
        FragmentPaginaWeb.OnFragmentInteractionListener, FragmentFacebook.OnFragmentInteractionListener {

    /*VARIABLES DEL SERVIDOR lOCAL Y WEB PARA LA RUTA DE CONSULTAS */
    //public static String RutaLocal = "http://10.0.2.2";
    //public static String RutaWeb = "http://www.elbisne.xolotlcl.com";
    public static String RutaWeb =  "http://www.elbisne.xolotlcl.com";
    private ImageView photoImageView;
    private TextView nameTextView;
    private TextView emailTextView;
    private TextView idTextView;
    private ProgressDialog mProgress;
    Dialog customDialog = null;

    //Variable de probabilidad de Ticket
    public static int probabilidad = 0;

    /*Variables para Buscar NEgocios*/
    MaterialSearchView searchView;
    //ListView lstView;
    public static String ValorBusqueda ="";
    private String SEACH_NAME = "SearchName";

    public TextView lblMensaje;
    private List<SearchNegocio> searchNegocios;
    private RecyclerView listaNegocios;
    private AdaptadorSearchNegocios adaptador;
    /*END Variables para Buscar NEgocios*/

    public static String emailActivo;
    private GoogleApiClient googleApiClient;

    private FirebaseAuth firebaseAuth;
    private FirebaseAuth.AuthStateListener firebaseAuthListener;

    //FRAGMENTS
    FragmentPerfil fragmentPerfil;
    FragmentRegistroNegocios fragmentRegistroNegocios;
    FragmentAnuncios fragmentAnuncios;
    AyudaFragment ayudaFragment;
    FragmentPaginaWeb fragmentPaginaWeb;
    FragmentFacebook fragmentFacebook;
    FragmentTransaction fragmentTransaction;
    FragmentBusqueda fragmentBusqueda;

    //Variables para localizacion del usuario
    LocationManager locationManager;
    double longitudeBest, latitudeBest;
    public static String PosicionGps = "Longitud: -98.75913109999999" + "_" + "Latitud: 20.1010608";
    //Variables para Cargar Negocios
    String IdNego="";
    private String KEY_IDNEGOCIO = "IdNegocio";
    //Variables paraCargar Perfil
    private String KEY_EMAIL = "UserEmail";

    //Eñlekentos para PushNotifications
    public static final String TAG = "NOTICIAS";
    //Elementos en Contenedor Main
    ViewGroup ContenedorNoConnection;
    Button btnReintentarCon;

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        return false;
        // Disable back button..............
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar)findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Busqueda de Negocios");
        toolbar.setTitleTextColor(Color.parseColor("#FFFFFF"));

        //Contenedor de conexion deficiente
        ContenedorNoConnection = (ViewGroup)findViewById(R.id.ContenedorNoConnection);
        btnReintentarCon = (Button)findViewById(R.id.btnReintentarCon);

        try {
            PackageInfo info = getPackageManager().getPackageInfo(
                    "com.example.deadshot.elbisne",
                    PackageManager.GET_SIGNATURES);
            for (Signature signature : info.signatures) {
                MessageDigest md = MessageDigest.getInstance("SHA");
                md.update(signature.toByteArray());
                Log.d("KeyHash:", Base64.encodeToString(md.digest(), Base64.DEFAULT));
                //Toast.makeText(getApplicationContext(), Base64.encodeToString(md.digest(),Base64.DEFAULT), Toast.LENGTH_LONG).show();
            }
        }catch (PackageManager.NameNotFoundException e){

        }catch (NoSuchAlgorithmException e){

        }

        if (getIntent().getExtras() != null) {
            if (MiFirebaseMessagingService.titleN != null){
                if (MiFirebaseMessagingService.typeN.equals("laravelnego")){
                    ShowSuscripcion(
                            MiFirebaseMessagingService.titleN,
                            MiFirebaseMessagingService.bodyN,
                            MiFirebaseMessagingService.contatoN,
                            "warning"
                    );
                }
                if (MiFirebaseMessagingService.typeN.equals("laravelticket")){
                    ShowSuscripcion(
                            MiFirebaseMessagingService.titleN,
                            MiFirebaseMessagingService.bodyN,
                            MiFirebaseMessagingService.contatoN,
                            "gif"
                    );
                }
            }
        }

        String token = FirebaseInstanceId.getInstance().getToken();

        //Indicializacion del servicio de ubicacion
        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        /*INSTANCIAR FRAGMENT PERFIL DEL USUARIO*/
        fragmentPerfil = new FragmentPerfil();
        ayudaFragment = new AyudaFragment();
        fragmentRegistroNegocios = new FragmentRegistroNegocios();
        fragmentAnuncios = new FragmentAnuncios();
        fragmentPaginaWeb = new FragmentPaginaWeb();
        fragmentFacebook = new FragmentFacebook();
        fragmentBusqueda = new FragmentBusqueda();
        ///fragmentTransaction = getSupportFragmentManager().beginTransaction();
        /*END INSTANCIA FRAGMENT PERFIL DEL USUARIO*/

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);
        navigationView.setItemIconTintList(null);
        /*Autenticacion Facebook Firebase*/

        /*END Autenticacion Facebook Firebase*/
        /* Autenticacion Goolge / FireBase*/
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestEmail()
                .build();

        googleApiClient = new GoogleApiClient.Builder(this)
                .enableAutoManage(this, this)
                .addApi(Auth.GOOGLE_SIGN_IN_API, gso)
                .build();

        firebaseAuth = FirebaseAuth.getInstance();
        firebaseAuthListener = new FirebaseAuth.AuthStateListener() {
            @Override
            public void onAuthStateChanged(@NonNull FirebaseAuth firebaseAuth) {
                FirebaseUser user = firebaseAuth.getCurrentUser();
                if (user != null) {
                    setUserData(user);
                } else {
                    goLogInScreen();
                }
            }
        };
        /*END Metodos Autenticacion Google / Firebase*/
        /*CARGAR ANUNCIOS POR DEFECTO*/
        btnReintentarCon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                CargarMenuPrincipal();
            }
        });
        CargarMenuPrincipal();
        //Inicion de Ubicacion
        GetLocGPS();
        searchView = (MaterialSearchView)findViewById(R.id.search_view);
        searchView.setOnSearchViewListener(new MaterialSearchView.SearchViewListener() {
            @Override
            public void onSearchViewShown() {
                Toast.makeText(MainActivity.this,"Buscando..",Toast.LENGTH_LONG);
            }

            @Override
            public void onSearchViewClosed() {
                CargarMenuPrincipal();
            }
        });
        searchView.setOnQueryTextListener(new MaterialSearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                String old;
                if(query != null && !query.isEmpty()){
                    old = ValorBusqueda;
                    if (query != old){
                        ValorBusqueda = query;
                        CargarSearchNegocios();
                    }
                }
                else{
                    CargarMenuPrincipal();
                }
                return true;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                return false;
            }

        });
        //Cargar el envio del Token del usuario a la db
        enviarTokenAlServidor(token);
    }

    /*Enviar Valor del Token ala base de datos*/
    private void enviarTokenAlServidor(final String token) {
        // Enviar token al servidor
        StringRequest stringRequest = new StringRequest(Request.Method.POST, RutaWeb +"/consultasdbNegocios/SetToken.php",
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String s) {
                        Log.d("onResponse",s);
                        //Toast.makeText(MainActivity.this,"Token Actualizado",Toast.LENGTH_LONG).show();
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
    /*END Enviar Valor del Token ala base de datos*/
    /*Metodos MainActivity Drawer Navigation*/
    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        MenuItem item = menu.findItem(R.id.action_search);
        item.setTitle("Buscar Negocio");
        searchView.setMenuItem(item);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_search) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.

        int id = item.getItemId();

        if (id == R.id.menuprincipal) {
            CargarMenuPrincipal();
        } else if (id == R.id.perfil) {
            CargarPerfil();
        } else if (id == R.id.negocio) {
            CargarRegistroNegocios();
        } else if (id == R.id.ayuda) {
            CargarAyuda();
        } else if (id == R.id.closeSesion) {
            CerrarSesion();
        } else if (id == R.id.facebook) {
            CargarFacebook();
        } else if (id == R.id.pagina) {
            CargarPaginaWeb();
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    private void CerrarSesion() {
        AlertDialog alertDialog = new AlertDialog.Builder(MainActivity.this).create();
        alertDialog.setTitle("ADVERTENCIA !!");
        alertDialog.setMessage("ESTAS A PUNTO DE CERRAR TU SESIÓN. ¿DESEA CONTINUAR?");
        alertDialog.setButton(AlertDialog.BUTTON_NEGATIVE, "No",
                new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                });
        alertDialog.setButton(AlertDialog.BUTTON_POSITIVE, "Si",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int which) {
                        firebaseAuth.signOut();

                        Auth.GoogleSignInApi.signOut(googleApiClient).setResultCallback(new ResultCallback<Status>() {
                            @Override
                            public void onResult(@NonNull Status status) {
                                if (status.isSuccess()) {
                                    goLogInScreen();
                                } else {
                                    Toast.makeText(getApplicationContext(), "No Se Puede Cerrar Sesión", Toast.LENGTH_SHORT).show();
                                    finish();
                                }
                            }
                        });
                    }
                });
        alertDialog.show();
    }

    /*END Metodos Base MainActivity */

    /* Metodos Implementacion Auth Google y FireBase*/
    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

    }

    private void setUserData(FirebaseUser user) {
        //Instancia HeaderNavView del Navigation Drawer
        View header = ((NavigationView) findViewById(R.id.nav_view)).getHeaderView(0);
        //Instancia para la imagen del Nav Navigation Drawer
        ImageView photo = (ImageView) header.findViewById(R.id.UserImage);

        ((TextView) header.findViewById(R.id.UserName)).setText(user.getDisplayName());
        ((TextView) header.findViewById(R.id.UserMail)).setText(user.getEmail());
        Glide.with(this).load(user.getPhotoUrl()).into(photo);
        emailActivo = user.getEmail().toString();
    }

    @Override
    protected void onStart() {
        super.onStart();
        firebaseAuth.addAuthStateListener(firebaseAuthListener);
    }

    private void goLogInScreen() {
        Intent intent = new Intent(this, ActivityInicioSesion.class);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(intent);
    }

    public void logOut(View view) {
        firebaseAuth.signOut();
        FirebaseAuth.getInstance().signOut();
        LoginManager.getInstance().logOut();
        Auth.GoogleSignInApi.signOut(googleApiClient).setResultCallback(new ResultCallback<Status>() {
            @Override
            public void onResult(@NonNull Status status) {
                if (status.isSuccess()) {
                    goLogInScreen();
                } else {
                    Toast.makeText(getApplicationContext(), "No se puede cerrar sesión", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    public void revoke(View view) {
        firebaseAuth.signOut();

        Auth.GoogleSignInApi.revokeAccess(googleApiClient).setResultCallback(new ResultCallback<Status>() {
            @Override
            public void onResult(@NonNull Status status) {
                if (status.isSuccess()) {
                    goLogInScreen();
                } else {
                    Toast.makeText(getApplicationContext(), "Error Al Revocar Sesion", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    @Override
    protected void onStop() {
        super.onStop();

        if (firebaseAuthListener != null) {
            firebaseAuth.removeAuthStateListener(firebaseAuthListener);
        }
    }

    /*END Metodos Implementacion Auth Google y FireBase*/
    //Implementacion de Fragment
    @Override
    public void onFragmentInteraction(Uri uri) {

    }//END interaccion Fragment

    //Muestra El Menu Principal
    public void CargarMenuPrincipal() {
        if(isOnline()){
            ContenedorNoConnection.setVisibility(View.GONE);
            FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.replace(R.id.ContenedorMain, fragmentAnuncios);
            getSupportActionBar().setTitle("Anuncios de negocios");
            //transaction.addToBackStack(null);
            transaction.commit();
        }else{
            ContenedorNoConnection.setVisibility(View.VISIBLE);
            Toast.makeText(MainActivity.this, "Revisa tu conexión a internet.", Toast.LENGTH_SHORT).show();
        }
    }

    //Consulta para cargar datos del perfil del usuario
    public void CargarPerfil() {
        //Verificar Conexion a internet
        if(isOnline()){
            ContenedorNoConnection.setVisibility(View.GONE);
            FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.replace(R.id.ContenedorMain, fragmentPerfil);
            getSupportActionBar().setTitle("Perfil de " + emailActivo.toString());
            //transaction.addToBackStack(null);
            transaction.commit();
        }else{
            ContenedorNoConnection.setVisibility(View.VISIBLE);
            Toast.makeText(MainActivity.this, "Revisa tu conexión a internet.", Toast.LENGTH_SHORT).show();
        }
        //END Verificar Conexion a internet
    }//END Cargar Datos delPerfil

    //Carga la Busqueda del Anuncusio
    public void CargarSearchNegocios(){
        //Verificar Conexion a internet
        if(isOnline()){
            FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            ContenedorNoConnection.setVisibility(View.GONE);
            transaction.replace(R.id.ContenedorMain, fragmentBusqueda);
            getSupportActionBar().setTitle("Búsqueda de negocios");
            //transaction.addToBackStack(null);
            transaction.commit();
        }else{
            ContenedorNoConnection.setVisibility(View.VISIBLE);
            Toast.makeText(MainActivity.this, "Revisa tu conexión a internet.", Toast.LENGTH_SHORT).show();
        }
        //END Verificar Conexion a internet
    }//End de la carga de busqueda del negocio

    //Metodo para cargar el registro de negocios
    public void CargarRegistroNegocios() {
        //Cargar Registro Negocios Con Tabs
        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction transaction = fragmentManager.beginTransaction();
        transaction.replace(R.id.ContenedorMain, fragmentRegistroNegocios);
        Bundle data = new Bundle();
        data.putString("EmailUser", emailActivo.toString());
        fragmentRegistroNegocios.setArguments(data);
        getSupportActionBar().setTitle("Registra tu negocio");
        //transaction.addToBackStack(null);
        transaction.commit();
    }//END Metodo para Cargar el Registro de negocios

    //Metodo para Cargar la Pagina Web de la Aplicacion
    public void CargarPaginaWeb() {
        //Verificar Conexion a internet
        if(isOnline()){
            ContenedorNoConnection.setVisibility(View.GONE);
            FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.replace(R.id.ContenedorMain, fragmentPaginaWeb);
            getSupportActionBar().setTitle("Página web Mi Bisne");
            //transaction.addToBackStack(null);
            transaction.commit();
        }else{
            ContenedorNoConnection.setVisibility(View.VISIBLE);
            Toast.makeText(MainActivity.this, "Revisa tu conexión a internet.", Toast.LENGTH_SHORT).show();
        }
        //END Verificar Conexion a internet
    }//END Metodo para Cargar la Pagina Web de la Aplicacion

    //Metodo para Cargar el Facebook de la Aplicacion
    public void CargarFacebook() {
        //Verificar Conexion a internet
        if(isOnline()){
            ContenedorNoConnection.setVisibility(View.GONE);
            FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.replace(R.id.ContenedorMain, fragmentFacebook);
            getSupportActionBar().setTitle("Facebook de Mi Bisne");
            //transaction.addToBackStack(null);
            transaction.commit();
        }else{
            ContenedorNoConnection.setVisibility(View.VISIBLE);
            Toast.makeText(MainActivity.this, "Revisa tu conexión a internet.", Toast.LENGTH_SHORT).show();
        }
        //END Verificar Conexion a internet
    }//END Metodo para Cargar el Facebook de la Aplicacion

    //Consulta para cargar datos del Ayuda
    public void CargarAyuda() {
        //Verificar Conexion a internet
        if(isOnline()){
            ContenedorNoConnection.setVisibility(View.GONE);
            FragmentManager fragmentManager = getSupportFragmentManager();
            FragmentTransaction transaction = fragmentManager.beginTransaction();
            transaction.replace(R.id.ContenedorMain, ayudaFragment);
            getSupportActionBar().setTitle("Menú de ayuda");
            //transaction.addToBackStack(null);
            transaction.commit();
        }else{
            ContenedorNoConnection.setVisibility(View.VISIBLE);
            Toast.makeText(MainActivity.this, "Revisa tu conexión a internet.", Toast.LENGTH_SHORT).show();
        }
        //END Verificar Conexion a internet
    }//END Cargar Datos deAyuda

    private String downloadUrl(String myurl) throws IOException {
        Log.i("URL", "" + myurl);
        myurl = myurl.replace(" ", "%20");
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
    /*END METODOS PARA CARGAR EL PERFIL,AYUDA DEL USUARIO*/

    /*METODOS PARA OBTENER LA UBICACION DEL USUARIO*/
    private boolean checkLocation() {
        if (!isLocationEnabled())
            showAlert();
        return isLocationEnabled();
    }

    private void showAlert() {
        final AlertDialog.Builder dialog = new AlertDialog.Builder(this);
        dialog.setTitle("Activar localización")
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
                        PosicionGps = "Longitud: -98.75913109999999" + "_" + "Latitud: 20.1010608";
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
        if (ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

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
                    PosicionGps = "Longitud: " + longitudeBest + "_" + "Latitud: " + latitudeBest;
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

    /*CHECK DE CONECCTION TO INTERNET*/
    protected boolean isOnline() {
        ConnectivityManager connectivityManager = (ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connectivityManager.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnectedOrConnecting()) {
            return true;
        } else {
            return false;
        }
    }
    public void checkConnection(){
        if(isOnline()){
            Toast.makeText(MainActivity.this, "You are connected to Internet", Toast.LENGTH_SHORT).show();
        }else{
            Toast.makeText(MainActivity.this, "You are not connected to Internet", Toast.LENGTH_SHORT).show();
        }
    }
    /*END CHECK DE CONECCTION TO INTERNET*/
    /*Metodos de Alert para notificaciones*/
    public void ShowSuscripcion(String hearder, String body, final String contacto, String img){
        // con este tema personalizado evitamos los bordes por defecto
        customDialog = new Dialog(this,R.style.Theme_Dialog_Translucent);
        //deshabilitamos el título por defecto
        customDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        //obligamos al usuario a pulsar los botones para cerrarlo
        customDialog.setCancelable(false);
        //establecemos el contenido de nuestro dialog
        customDialog.setContentView(R.layout.dialog);

        TextView titulo = (TextView) customDialog.findViewById(R.id.titulo);
        titulo.setText(hearder);

        TextView contenido = (TextView) customDialog.findViewById(R.id.contenido);
        contenido.setText(body);

        ImageView imgnotif = (ImageView) customDialog.findViewById(R.id.imgnotif);
        if (img.equals("gif")){
            Glide.with(this)
                    .load(R.drawable.gif).centerCrop()
                    .skipMemoryCache(true)
                    .override(200,200)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                    .into(imgnotif);
        }else if (img.equals("warning")){
            Glide.with(this)
                    .load(R.drawable.warning).centerCrop()
                    .skipMemoryCache(true)
                    .override(200,200)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .signature(new StringSignature(String.valueOf(System.currentTimeMillis())))
                    .into(imgnotif);
        }

        ((Button) customDialog.findViewById(R.id.btnLlamarAdmin)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                customDialog.dismiss();
                String number = contacto;
                Uri call = Uri.parse("tel:" + number);
                Intent surf = new Intent(Intent.ACTION_DIAL, call);
                startActivity(surf);
            }
        });

        ((Button) customDialog.findViewById(R.id.btnContinuar)).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                customDialog.dismiss();
                Toast.makeText(getApplicationContext(),"Bienvenido !!",Toast.LENGTH_LONG).show();
            }
        });

        customDialog.show();

    }
    /*END Metodos de Alert para notificaciones*/
}