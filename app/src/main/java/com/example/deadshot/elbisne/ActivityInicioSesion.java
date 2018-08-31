package com.example.deadshot.elbisne;

import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
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
import com.facebook.AccessToken;
import com.facebook.CallbackManager;
import com.facebook.FacebookCallback;
import com.facebook.FacebookException;
import com.facebook.login.LoginManager;
import com.facebook.login.LoginResult;
import com.facebook.login.widget.LoginButton;
import com.google.android.gms.auth.api.Auth;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.auth.api.signin.GoogleSignInResult;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.SignInButton;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthCredential;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FacebookAuthCredential;
import com.google.firebase.auth.FacebookAuthProvider;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.auth.GoogleAuthProvider;

import com.facebook.FacebookSdk;
import com.facebook.appevents.AppEventsLogger;


import org.json.JSONArray;
import org.json.JSONException;

import java.util.Arrays;
import java.util.Hashtable;
import java.util.Map;

public class ActivityInicioSesion extends AppCompatActivity implements GoogleApiClient.OnConnectionFailedListener {

    private static final String TAG = "Auth";
    private GoogleApiClient googleApiClient;
    public static final int SIGN_IN_CODE = 777;
    //Button for Google
    private SignInButton signInButton;
    //Button for Facebook
    private LoginButton loginButton;
    private CallbackManager callbackManager;

    private FirebaseAuth firebaseAuth;
    private FirebaseAuth.AuthStateListener firebaseAuthListener;

    public EditText txtUserEmail, txtpassword;
    public Button btnIniciS, btnregistrouser;
    public Button btnFacebook;

    //VARIABLES DE CORREO Y CONTRASEÑA DEL USUARIO CON GOOGLE
    String IdUsuario, email, password ="";
    private String CORREO = "IdUsuario";
    /*VARIABLES DEL SERVIDOR lOCAL Y WEB PARA LA RUTA DE CONSULTAS */
    //Ruta del Servidor Web
    public static String UPLOAD_URL="http://www.elbisne.xolotlcl.com/";
    private String UPLOAD_URLLocal ="http://10.0.2.2/";
    private ProgressDialog mProgress;

    public static int valorActual =0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_inicio_sesion);

        //Instancia Elementos del Layoud
        txtpassword = (EditText)findViewById(R.id.txtContIniS);
        txtUserEmail = (EditText)findViewById(R.id.txtNombreEmail);
        btnIniciS = (Button)findViewById(R.id.btnIniciar);
        btnregistrouser = (Button)findViewById(R.id.btnregistrouser);


        callbackManager = CallbackManager.Factory.create();
        loginButton = (LoginButton)findViewById(R.id.loginButton);
        //Agregue nuevos permisos aparte del correo electrónico
        loginButton.setReadPermissions(Arrays.asList("email", "public_profile", "user_friends"));
        loginButton.registerCallback(callbackManager, new FacebookCallback<LoginResult>() {
            @Override
            public void onSuccess(LoginResult loginResult) {

                handleFacebookAccessToken(loginResult.getAccessToken());
            }

            @Override
            public void onCancel() {
                Toast.makeText(getApplicationContext(), "Inicio de sesión cancelado", Toast.LENGTH_LONG).show();
            }

            @Override
            public void onError(FacebookException error) {
                Toast.makeText(ActivityInicioSesion.this,""+error,Toast.LENGTH_SHORT).show();
                //Toast.makeText(getApplicationContext(), "Ha ocurrido un error intentalo mas tarde", Toast.LENGTH_LONG).show();
            }
        });
        //END Elementos del Layoud
        //Instalcioa para Inicio de Sesion Google
        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestIdToken(getString(R.string.default_web_client_id))
                .requestEmail()
                .build();

        googleApiClient = new GoogleApiClient.Builder(this)
                .enableAutoManage(this, this)
                .addApi(Auth.GOOGLE_SIGN_IN_API, gso)
                .build();

        signInButton = (SignInButton) findViewById(R.id.signInButton);

        signInButton.setSize(SignInButton.SIZE_WIDE);

        signInButton.setColorScheme(SignInButton.COLOR_DARK);

        signInButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                valorActual=1;
                Intent intent = Auth.GoogleSignInApi.getSignInIntent(googleApiClient);
                startActivityForResult(intent, SIGN_IN_CODE);
            }
        });
        //END Instancia para Inicio de Sesion Goolge
        //Instancia para Auth Firebase
        firebaseAuth = FirebaseAuth.getInstance();
        firebaseAuthListener = new FirebaseAuth.AuthStateListener() {
            @Override
            public void onAuthStateChanged(@NonNull FirebaseAuth firebaseAuth) {
                final FirebaseUser user = firebaseAuth.getCurrentUser();
                //if (valorActual > 0){
                    if (user != null) {
                        IdUsuario = user.getEmail().toString().trim();
                        String UidUser = user.getUid().toString();
                        //Mostrar el diálogo de progreso
                        final ProgressDialog loading = ProgressDialog.show(ActivityInicioSesion.this,"Verificando Datos...","Espere por favor...",false,false);
                        StringRequest stringRequest = new StringRequest(Request.Method.POST, UPLOAD_URL + "/consultasdbNegocios/CheckUser.php",
                                new Response.Listener<String>() {
                                    @Override
                                    public void onResponse(String s) {
                                        //Descartar el diálogo de progreso
                                        loading.dismiss();
                                        mProgress.dismiss();
                                        Log.d("OnResponse ",s);
                                        JSONArray ja = null;
                                        try {
                                            ja = new JSONArray(s);
                                            if (ja.getString(0).toString().equals("Usuario Existente")){
                                                goMainScreen();
                                            }else {
                                                goRegisterUser(user.getDisplayName(),user.getEmail());
                                            }
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                            Toast.makeText(ActivityInicioSesion.this, e.toString(),Toast.LENGTH_LONG).show();
                                        }
                                    }
                                },
                                new Response.ErrorListener() {
                                    @Override
                                    public void onErrorResponse(VolleyError volleyError) {
                                        //Descartar el diálogo de progreso
                                        loading.dismiss();
                                        mProgress.dismiss();
                                        //Showing toast
                                        Log.d("Volley Error",volleyError.getMessage().toString());
                                        Toast.makeText(ActivityInicioSesion.this, volleyError.getMessage().toString(), Toast.LENGTH_LONG).show();
                                    }
                                }){
                            @Override
                            protected Map<String, String> getParams() throws AuthFailureError {
                                //Creación de parámetros
                                Map<String,String> params = new Hashtable<String, String>();
                                //Agregando de parámetros
                                params.put(CORREO ,IdUsuario);
                                //Parámetros de retorno
                                return params;
                            }
                        };
                        //Creación de una cola de solicitudes
                        RequestQueue requestQueue = Volley.newRequestQueue(ActivityInicioSesion.this);
                        //Agregar solicitud a la cola
                        requestQueue.add(stringRequest);
                    }//END If comparacion dirente de null
                //}//End Comparacion de valor del boton google
            }
        };
        //END Instancia para Auth Firebase

        //Instancia para Botoon Inicio e Sesion DB Local
        btnIniciS.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (txtUserEmail.getText().toString().trim().equals("") || txtpassword.getText().toString().trim().equals("")){
                    Toast.makeText(ActivityInicioSesion.this,"Los campos son obligatorios",Toast.LENGTH_LONG).show();
                }else{
                    IniciarS();
                }
            }
        });

        //Instancia para Formulario de Inicio de Sesion
        btnregistrouser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent =new Intent(getApplicationContext(),ActivityRegistroUser.class);
                startActivity(intent);
                overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
                finish();
            }
        });

        //Dialog de progreso
        mProgress = new ProgressDialog(this);
    }

    private void handleFacebookAccessToken(AccessToken accessToken) {
        AuthCredential authCredential = FacebookAuthProvider.getCredential(accessToken.getToken());
        firebaseAuth.signInWithCredential(authCredential).addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
            @Override
            public void onComplete(@NonNull Task<AuthResult> task) {

            }
        });
    }


    //Determinar Inicio de la Activity
    @Override
    protected void onStart() {
        super.onStart();

        firebaseAuth.addAuthStateListener(firebaseAuthListener);
        FirebaseUser currentUser = firebaseAuth.getCurrentUser();
        //updateUI(currentUser);
    }
    //Inicio de Sesion datos locales en firebase
    public void IniciarS(){
        final ProgressDialog loading = ProgressDialog.show(this,"Iniciando sesión","Espere por favor...",false,false);
        email = txtUserEmail.getText().toString().trim();
        password = txtpassword.getText().toString().trim();

        firebaseAuth.signInWithEmailAndPassword(email, password)
                .addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        Log.d(TAG, "signInWithEmail:onComplete:" + task.isSuccessful());

                        // If sign in fails, display a message to the user. If sign in succeeds
                        // the auth state listener will be notified and logic to handle the
                        // signed in user can be handled in the listener.
                        if (!task.isSuccessful()) {
                            Log.w(TAG, "signInWithEmail", task.getException());
                            Toast.makeText(ActivityInicioSesion.this, "Correo o contraseña incorrecta",
                                    Toast.LENGTH_SHORT).show();
                            loading.dismiss();
                        }
                        loading.dismiss();

                        // ...
                    }
                });

    }//END Inicio de Sesion datos  locales en firebase

    //Inicio de Secion con Google y FireBase
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);



        if (requestCode == SIGN_IN_CODE) {
            GoogleSignInResult result = Auth.GoogleSignInApi.getSignInResultFromIntent(data);
            handleSignInResult(result);
        }
        callbackManager.onActivityResult(requestCode,resultCode,data);

    }

    private void handleSignInResult(GoogleSignInResult result) {
        //Toast.makeText(ActivityInicioSesion.this,"-- "+result.getStatus(),Toast.LENGTH_LONG).show();
        if (result.isSuccess()) {
            firebaseAuthWithGoogle(result.getSignInAccount());
        } else {
            Toast.makeText(this, "No se Puede Iniciar Sesion", Toast.LENGTH_SHORT).show();
        }
    }

    private void firebaseAuthWithGoogle(GoogleSignInAccount signInAccount) {

        mProgress.setMessage("Iniciando sesión, espere...");
        mProgress.show();

        AuthCredential credential = GoogleAuthProvider.getCredential(signInAccount.getIdToken(), null);
        firebaseAuth.signInWithCredential(credential).addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
            @Override
            public void onComplete(@NonNull Task<AuthResult> task) {
                mProgress.dismiss();
                if (!task.isSuccessful()) {
                    Toast.makeText(getApplicationContext(), "Error de conexión", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }
    //Metodo para iniciar el mainActivity
    private void goMainScreen() {
        Intent intent = new Intent(this, MainActivity.class);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(intent);
        overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
    }
    //Metodo para Iniciar el registro de datos si el usuario no esta registrado en la db MySQL
    private void goRegisterUser(String displayName, String email){
        Intent i = new Intent(this, ActivityRegistroGoogle.class);
        i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
        i.putExtra("displayName",displayName);
        i.putExtra("email", email);
        startActivity(i);
        overridePendingTransition(R.anim.push_left_in, R.anim.push_left_out);
    }

    @Override
    protected void onStop() {
        super.onStop();

        if (firebaseAuthListener != null) {
            firebaseAuth.removeAuthStateListener(firebaseAuthListener);
            LoginManager.getInstance().logOut();
        }
        LoginManager.getInstance().logOut();
    }

    @Override
    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {
        Toast.makeText(this,"Verifica tu conexión a Internet",Toast.LENGTH_LONG).show();
    }
    /*END Inicio de Sesion con Google y FireBase*/
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
                            ActivityInicioSesion.this.finish();
                        }
                    }).show();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}
