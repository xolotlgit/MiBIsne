@extends('layouts.app')
@section('content')
<!--Modal de Editar-->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h5>Editar usuario</h5></br>
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
                   <input id="tel1" type="text" class="form-control" name="tel1" value="{{ old('tel1') }}" required autofocus>
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
                  <input id="tel2" type="text" class="form-control" name="tel2" value="{{ old('tel2') }}" required autofocus>
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
</div><!--Fin Modal Editar-->

<!-- Modal Delete -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
        <h5>¿Esta seguro que desea eliminar este registro?</h5>
        <p class="justify">Tenga en cuenta que al eliminar este registro borrara todos los negocios relacionados con el. Esta seguro que desea continuar?</p>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
    </div>
    <div class="modal-footer">
        <button class="waves-effect btn" id="Eliminar" onclick="DeleteUsuario();" style="background-color:#E57373;">Eliminar<i class="material-icons prefix right">delete</i></button>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="CloseModal();">Cancelar</a>
    </div>
</div>

<!--Contenedor principal-->
<div class="container"></br>
   <div class="card">
      <div class="card-content">
        <div class="cont-padd"></br><span class="card-title"><b>USUARIOS DE LA APLICACIÓN</b></span></br></div>
            <!-- Etiquetas de abertura del contenedor principal-->      
            <div class="col s12">
                <div class="row">
                    <table id="buscausuarios" class="bordered highlight">
                        <thead>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="autocomplete" onkeyup="complete();" class="autocomplete" autofocus class="autocomplete">
                                <label for="autocomplete-input">Introduce el nombre del usuario que desee buscar </label>
                            </div>
                        </thead>
                        <div id="ResUser">

                        </div>
                    </table> 
                </div>
                <div class="row hide" id="userid">
                    <table id="userselec" class="bordered highlight">
                        <div id="ResUser2">
                            <div class="input-field col s12 m12 l12" id="listcard">
                                <input disabled  type="text" id="id" name="id" class="form-control hide">
                                <input disabled  type="text" id="Nombre_User" name="Nombre_User" class="form-control">
                            </div>
                        </div>
                    </table> 
                </div>
            </div>

            <div class="row">
                <div id="listadoUsuarios">
                    @foreach($usuarios as $user)
                    <div class="col s12 m11 l6">
                        <div class="card">
                            <div class="card-content">
                                <p class="col s12 m12 l12" id="nombreUser" name="nombreUser" style="font-size:17px;" class="justify"><b>{{$user->Nombre_User . ' ' . $user->Apellidos }}</b></p>
                                <p>Correo: {{$user->email}}</p>
                                <p>Teléfono: {{$user->Telefono1}}</p>
                                <input id="id" type="number" class="form-control hide" name="id" value="{{$user->id}}">
                            </div>  
                            <div class="card-action">
                                <button class="waves-effect waves-light btn modal-trigger" value"{{$user->id}}" onclick="GetDatos({{$user->id}});" href="#modal1" style="background-color:#E57373;"><i class="material-icons right">edit</i>Editar</button>
                                <button class="btn waves-effect waves-light red darken-2 modal-trigger" value"{{{$user->id}}}}" onclick="GetIdD({{$user->id}});" id="Eliminar" href="#modalDelete">Eliminar<i class="material-icons prefix right">delete</i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                   <!-- Etiquetas de cierre del contenedor principal-->
                </div>    
            </div>
            <!-- Paginación -->
            <center><b>{{ $usuarios->links() }}</b></center>
            </div>
        </div>
    </div>
</div>
@endsection

<!--Instancia para metodos Java-->
@section('metodosJava')
    $(document).ready(function(){
        $('.modal').modal();
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

    function CloseModal(){
        $('#modalDelete').modal('close');
    }//END Close Modal 

    function GetIdD($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/ver/usuarios/'+ $valor + '/delete', function(res){
            $('input#idget').val($valor);
        });
    }

    function DeleteUsuario(){
        $Id = $('input#idget').val()
        //alert($Id);
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/ver/usuarios/delete/' + $Id,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdUsuario: $('input#idget').val() },
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
    }///END DeleteUsuario

    //Busqueda de usuarios
    function complete() {
        var token = $('meta[name=csrf-token]').attr('content');
        $usuario =$('input#autocomplete').val();
        if ($usuario == "" || $usuario == " "){
            $('input#autocomplete').focus();
            $('div#listadoUsuarios').show();
            $("#ResUser div").remove();
        }else{
            $.get('/ver/usuarios/autousuario/'+ $usuario + '/', function(res){
                $('div#listadoUsuarios').hide();
                $("#ResUser div").remove();
                $(res).each(function(key, value){
                    $("div#ResUser").append('<div class="col s12 m11 l6" id="listcard"><div class="card"><div class="card-content"><input id="id" type="number" class="form-control hide" name="id" value="{{$user->id}}"><label id="nombreUser" name="nombreUser" style="font-size:17px;"><b>'+ value.Nombre_User + ' ' + value.Apellidos +'</b></label><p class="justificado"><b>Email:</b> '+ ' ' + value.email +' </p><p class="justificado"><b>Teléfono:</b> '+ ' ' + value.Telefono1 +'</p></div><div class="card-action"><button class="waves-effect waves-light btn btn-secundario modal-trigger" value"'+ value.id +'}" onclick="GetDatos('+ value.id +');" href="#modal1"><i class="material-icons right">edit</i>Editar</button><button class="btn waves-effect waves-light red darken-2 modal-trigger" value"'+ value.id +'" onclick="GetIdD('+ value.id +');" id="Eliminar" href="#modalDelete">Eliminar<i class="material-icons prefix right">delete</i></button></div></div></div>');
                });
            });
        }
    }//Cierre Busqueda de usuarios
    
 @endsection

