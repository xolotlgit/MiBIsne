@extends('layouts.layoutUser')

@section('content')
<!--Modal de Editar-->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h5>Editar Usuario</h5></br>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
        
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="input-field col s12 m12 l12">
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
                   <input id="email" type="email" maxlength="60" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
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
                    <input id="tel2" type="text" maxlength="10" class="form-control" name="tel2" value="{{ old('tel2') }}" required autofocus>
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
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <a class="waves-effect waves-light btn modal-trigger" onclick="SetDatosAct();" href="#modal1">Guardar</a>
                    <a class=" btn" href="#" style="background-color:#E57373;">
                       Cancelar
                    </a>
                </div>
            </div>
        </div>
   </div>   
<!--Fin del modal-->

    <div></br> </br></div>
        <div class="container">
            <div class="card col s12 m7 l8">
                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Tu Perfil<i class="material-icons right">more_vert</i></span>
                </div>
                <div class="card-reveal ">
                    <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                    <p class="justify" autofocus>Estos son los datos con los que te has dado de alta como un usuario de Mi Bisne, 
                    en caso de querer cambiarlos, solo deberás dar clic en la opción o en el icono de editar.</p>
                </div>
            </div></br>
            <!--Contendor de Perfil de usuario-->
            <div class="card ">
                <div class="card-image">
                    <a class="btn-floating tooltipped halfway-fab waves-effect waves-light green modal-trigger" data-delay="50" data-tooltip="Editar perfil" value"{{$user->id}}" onclick="GetDatos({{$user->id}});" href="#modal1"><i class="material-icons">edit</i></a>
                </div>
                <div class="card-content">
                    <div class="userdata" line-height>
                        <p class="card-title"><b> {{$user->Nombre_User . ' ' . $user->Apellidos}}</b></p>
                        <p>Usuario: {{$user->Alias_Usuario}}</p>
                        <p>Email: {{$user->email}}</p>
                        <p>Dirección: {{$user->Direccion}}</p>
                        <p>Teléfono Fijo: {{$user->Telefono1}} </p>
                        <p>Teléfono Móvil: {{$user->Telefono2}}</p>
                        <input id="id" type="number" class="form-control hide" name="id" value="{{$user->id}}">
                    </div>
                </div>
                <div class="card-action">
                    <button class="waves-effect waves-light btn modal-trigger" value"{{$user->id}}" onclick="GetDatos({{$user->id}});" href="#modal1">Editar Perfil</button>
                </div>
            </div>

        </div>
    </div>
</div></br></br></br></br></br>

@endsection

<!--Instancia para metodos Java-->
@section('metodosJava')
    $(document).ready(function(){
        $('.modal').modal();
        Materialize.toast(value.mensaje, 4000);
    });

    function GetDatos($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/usuarios/'+ $valor + '/edit', function(res){
            $('input#idget').val($valor);
            $('input#name').val(res.Nombre_User);
            $('input#apellidos').val(res.Apellidos);
            $('input#email').val(res.email);
            $('input#direccion').val(res.Direccion);
            $('input#tel1').val(res.Telefono1);
            $('input#tel2').val(res.Telefono2);
            $('input#alias').val(res.Alias_Usuario);
            $('input#password').val(res.password);
            $('input#password').val(res.Clave);
        });
    }
    function SetDatosAct(){
        $btn = $('input#idget').val();
        
        $.ajax({
            url: '/usuarios/' + $btn,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { Nombre_User: $('input#name').val(), Apellidos: $('input#apellidos').val(),email: $('input#email').val(),Direccion: $('input#direccion').val(),Telefono1: $('input#tel1').val(),Telefono2: $('input#tel2').val(),Alias_Usuario: $('input#alias').val(),password: $('input#password').val(),Clave: $('input#password').val()},
            success: function(value){
                Materialize.toast(value.mensaje, 4000);
                $('#modal1').modal('close');
                /*Recargamos desde caché*/
                location.reload();
                /*Forzamos la recarga*/
                location.reload(true);
            },
            error: function(valie){
                Materialize.toast("Ha ocurrido un error al enviar los datos", 4000);
            }
        });
    }
    
 @endsection

