@extends('layouts.layoutComplete')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m1 l10 offset-m2 offset-l1">
            <form class="form-horizontal" role="form" method="POST" action="{{url('usuario')}}" onsubmit="return validarFormulario()">
            {{ csrf_field() }}
            </br></br>
            <div class="card">
                <div class="card-content">
                    <input id="idget" type="hidden" class="form-control hide" name="idget" value="{{$user->id}}" >
                    <div class="ins-inf-comp"></br>
                        <p class="card-title"><b>ATENCIÓN</b></p>
                        <p>Antes de continuar completa los siguientes datos, es importante que establezcas un usuario y contraseña ya que con ellas también podrás acceder a tu cuenta.</p></br>
                    </div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="name" type="text" maxlength="255" class="form-control" name="name" value="{{$user->Nombre_User}}"  required autofocus>
                             @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Nombre</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">edit</i>
                            <input id="apellidos" type="text" maxlength="255" class="form-control" name="apellidos" value="{{ old('apellidos') }}" required autofocus>
                            @if ($errors->has('apellidos'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('apellidos') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Apellidos</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="email" maxlength="60" class="form-control" name="email" value="{{ $user->email }}" disabled="disabled" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Email</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">home</i>
                            <input id="direccion" type="text" maxlength="255" class="form-control" name="direccion" value="{{ old('direccion') }}" required autofocus>
                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('direccion') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Dirección</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tel1') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">phone</i>
                            <input id="tel1" type="text" maxlength="10" class="form-control" name="tel1" value="{{ old('tel1') }}" required autofocus>
                            @if ($errors->has('tel1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tel1') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Teléfono</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('tel2') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">phone_android</i>
                            <input id="tel2" type="text" maxlength="10" class="form-control" name="tel2" value="{{ old('tel2') }}" autofocus>
                            @if ($errors->has('tel2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tel2') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Teléfono alternativo</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">person</i>
                            <input id="alias" type="text" maxlength="50" class="form-control" name="alias" value="{{ old('alias') }}" required autofocus>
                            @if ($errors->has('alias'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('alias') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Nombre de usuario</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" type="password" maxlength="255" class="form-control" name="password" required autofocus>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                            <label for="icon_prefix" style="font-size:12px;">Contraseña</label>
                        </div> 
                    </div></br>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button class="waves-effect waves-light btn" type="submit">Guardar información</button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

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