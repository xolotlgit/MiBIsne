@extends('layouts.app')

@section('content')
<div></br> </br></div>
<div class="container">
<div class="row">
        <div class="col s12 m8  l10 offset-m2 offset-l1 ">
          <div class="card">
            <div class="card-content">
                <div class="cont-padd"><span class="card-title"><b>Registro de Usuarios</b></span></div></br>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" onsubmit="return validarFormulario()">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:12px;">Nombre</label>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">edit</i>
                                <input id="apellidos" type="text" maxlength="255" class="form-control" name="apellidos" value="{{ old('apellidos') }}" required >
                                @if ($errors->has('apellidos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('apellidos') }}</strong>
                                    </span>
                                @endif
                                 <label for="icon_prefix" style="font-size:12px;">Apellidos</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">email</i>
                                <input id="email" type="email" maxlength="60" class="form-control" name="email" value="{{ old('email') }}" required >
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:12px;">Email</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                              <i class="material-icons prefix">home</i>
                                <input id="direccion" type="text" maxlength="255" class="form-control" name="direccion" value="{{ old('direccion') }}" required>
                                @if ($errors->has('direccion'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:12px;">Dirección</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tel1') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                              <i class="material-icons prefix">phone</i>
                                <input id="tel1" type="text" maxlength="10" class="form-control" name="tel1" value="{{ old('tel1') }}" required>
                                @if ($errors->has('tel1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tel1') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:12px;">Teléfono</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tel2') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                              <i class="material-icons prefix">phone_android</i>
                                <input id="tel2" type="text" maxlength="10" class="form-control" name="tel2" value="{{ old('tel2') }}" >
                                @if ($errors->has('tel2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tel2') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:12px;">Teléfono alternativo</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                              <i class="material-icons prefix">person</i>
                                <input id="alias" type="text" maxlength="50" class="form-control" name="alias" value="{{ old('alias') }}" onChange="return autentica();" required >
                                @if ($errors->has('alias'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:12px;">Nombre de usuario</label>
                            </div>
                        </div>
                      <!-- <span id="error">Lo sentimos, este nombre de usuario esta ocupado, deberá elegir otro.</span>-->

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m6 l6">
                              <i class="material-icons prefix">lock</i>
                                <input id="password" type="password" maxlength="255" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                 <label for="icon_prefix" style="font-size:12px;">Contraseña</label>
                            </div> 
                        </div>

                        <div class="form-group">
                           <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">lock_outline</i>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                 <label for="icon_prefix" style="font-size:12px;">Confirmar contraseña</label>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-red" style="font-size:13px;" id="btsubmit">
                                Registrar ahora
                                </button>
                            </div>
                        </div></br></br>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-firestore.js"></script>
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyA6kl-O33hP1fSejG3dt5s0l6YeSO9PJpY",
        authDomain: "el-bisne.firebaseapp.com",
        databaseURL: "https://el-bisne.firebaseio.com",
        projectId: "el-bisne",
        storageBucket: "el-bisne.appspot.com",
        messagingSenderId: "454352174040"
    };
    firebase.initializeApp(config);
</script>


<script>
    function validarFormulario(){
        var txtNombreUsuario = document.getElementById('name').value;
        var txtApellidos = document.getElementById('apellidos').value;
        var txtDireccion= document.getElementById('direccion').value;
        var txtTelefono= document.getElementById('tel1').value;
        var txtTelefono2= document.getElementById('tel2').value;
        var txtUsuario= document.getElementById('alias').value;
        var txtContraseña= document.getElementById('password').value;
        var txtConfContraseña = document.getElementById('password-confirm').value;

        //Nombre campo obligatorio
        if(txtNombreUsuario == null || txtNombreUsuario.length == 0 || /^\s+$/.test(txtNombreUsuario)){
             Materialize.toast('Atención: El nombre no puede ir vacío o lleno solo por espacios en blanco.', 8000);
            return false;
        }

        //Apellidos campo obligatorio
        if(txtApellidos == null || txtApellidos.length == 0 || /^\s+$/.test(txtApellidos)){
            Materialize.toast('Atención: El campo apellidos no puede ir vacío o lleno solo por espacios en blanco.', 8000);
            return false;
        }

        //Telefono campo obligatorio
        if( !(/^\d{10}$/.test(txtTelefono)) ) {
           Materialize.toast('Atención: Introduzca un numero de teléfono valido, Ejempo: 7717894710', 8000);
           return false;
        }

        //Direccion campo obligatorio
        if(txtDireccion == null || txtDireccion.length == 0 || /^\s+$/.test(txtDireccion)){
            Materialize.toast('Atención: El campo direccion no puede ir vacío o lleno solo por espacios en blanco.', 8000);
            return false;
        }

        //Direccion campo obligatorio
        if(txtUsuario == null || txtUsuario.length == 0 || /^\s+$/.test(txtUsuario)){
             Materialize.toast('Atención: El nombre de usuario no puede ir vacío', 8000);
            return false;
        }

        if(txtContraseña != txtConfContraseña){
            Materialize.toast('Verifique que las constraseñas sean iguales.', 8000);
            return false;
        }

         //Deshabilitar el botón una vez que se oprima guardar
        document.getElementById("btsubmit").value = "Guardando...";
        document.getElementById("btsubmit").disabled = true;
        SaveFireBase(txtEmail,txtContraseña);
        return true;
    }
</script>


@endsection

@section('metodosJava')
    $(document).ready(function(){
    
    });
    function SaveFireBase($email,$contra){
        // Initialize Firebase
        firebase.auth().createUserWithEmailAndPassword($email,$contra).catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log("Error : " + errorMessage);
        });

        var currentUser = firebase.auth().currentUser;
            if(currentUser != null){
                alert("Registro Exitoso;")
            }
    }
@endsection


