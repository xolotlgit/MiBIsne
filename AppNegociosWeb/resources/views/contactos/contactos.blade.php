@extends('layouts.app')

@section('content')
<!--Modal de Editar-->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h5>Información de contacto</h5></br>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
            <label for="nombre" class="col-md-4 control-label">Nombre</label>
            <div class="col-md-6">
                <input id="nombre" type="text" maxlength="50" class="form-control" name="nombre" required autofocus >
                @if ($errors->has('nombre'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nombre') }}</strong>
                    </span>
                @endif
            </div>
        </div>            
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">Email</label>
            <div class="col-md-6">
                <input id="email" type="email" maxlength="60" class="form-control" name="email"  required autofocus >
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('telefono1') ? ' has-error' : '' }}">
            <label for="telefono1" class="col-md-4 control-label">Teléfono</label>
            <div class="col-md-6">
                <input id="telefono1" type="tel" class="form-control" name="telefono1"  required autofocus >
                @if ($errors->has('telefono1'))
                    <span class="help-block">
                        <strong>{{ $errors->first('telefono1') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('telefono2') ? ' has-error' : '' }}">
            <label for="telefono2" class="col-md-4 control-label">Teléfono alternativo</label>
            <div class="col-md-6">
                <input id="telefono2" type="tel" class="form-control" name="telefono2" required autofocus >
                @if ($errors->has('telefono2'))
                    <span class="help-block">
                        <strong>{{ $errors->first('telefono2') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <a class="waves-effect waves-light btn modal-trigger" onclick="SetDatosAct();" href="#modal1">Guardar</a>
                <a class=" btn" href="#" style="background-color:#E57373;" onclick="CloseModalEdit();">
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</div> <!--Fin modal editar-->   

<!-- Modal Delete -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
        <h5>¿Esta seguro que desea eliminar este contacto?</h5>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
    </div>
    <div class="modal-footer">
        <button class="waves-effect btn" id="Eliminar" onclick="DeleteContacto();" style="background-color:#E57373;">Eliminar<i class="material-icons prefix right">delete</i></button>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="CloseModal();">Cancelar</a>
    </div>
</div>
<!--Fin modal eliminar-->
<div></br> </br></div>
  <div class="container">
    @if(session()->has('msg'))
        <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @endif
    @if(session()->has('msgerror'))
        <div class="alert alert-warning" role="alert">{{ session('msgerror')}}</div>
    @endif
    <div class="row">
        <div class="card">
            <div class="card-content">
               <span class="card-title col s9 m10 l10"><b>CONTACTOS</b></span> 
                </br> 
                <div class="panel-body">
                    <div class="row">
                        @foreach($contactos as $contacto)
                            <!-- aqui comineza los cards -->
                            <div class="col s12 m6 l6">
                                <div class="card">
                                    <div class="card-content">
                                        <p style="text-align:justify;font-size:15px;">Nombre: {{$contacto->Nombre}} </br>
                                        Telefono: {{$contacto->Telefono1}}</br>
                                        Correo: {{$contacto->Correo}}
                                        <input id="id" type="number" class="form-control hide" name="id" value="{{$contacto->IdContacto}}">
                                        </p> 
                                    </div>
                                    <div class="card-action">
                                        <button class="waves-effect waves-light btn modal-trigger" value"{{$contacto->IdContacto}}" onclick="GetDatos({{$contacto->IdContacto}});" href="#modal1" style="background-color:#E57373;"><i class="material-icons prefix right">create</i>Editar</button>
                                        <button class="waves-effect waves-light red darken-2 btn modal-trigger" value"{{$contacto->IdContacto}}" onclick="GetIdD({{$contacto->IdContacto}});" id="Eliminar" href="#modalDelete">Eliminar<i class="material-icons prefix right">delete</i></button>
                                    </div>
                                </div>
                            </div>
                            <!--aqui termina los cards-->
                        @endforeach
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<!--Instancia para metodos Java, deben ir aqui adentro para reconocer JS-->
@section('metodosJava')
    $(document).ready(function(){
        $('.modal').modal();
        Materialize.toast(value.mensaje, 4000);
    });

//Funciones para editar
    function GetDatos($valor){
        //alert($valor);
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/contactos/'+ $valor + '/edit', function(res){
            $('input#idget').val($valor);
            $('input#nombre').val(res.Nombre);
            $('input#email').val(res.Correo);
            $('input#telefono1').val(res.Telefono1);
            $('input#telefono2').val(res.Telefono2);
            //$('input#url').val(res.Direccion_Url);
        });
    }

//Funciones para editar
    function SetDatosAct(){
        $btn = $('input#idget').val();
        $.ajax({
            url: '/contactos/' + $btn,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { Nombre: $('input#nombre').val(), Correo: $('input#email').val(),Telefono1: $('input#telefono1').val(),Telefono2: $('input#telefono2').val() },
            success: function(value){
                Materialize.toast(value.mensaje, 4000);
                $('#modal1').modal('close');
                /*Recargamos desde caché*/
                location.reload();
                /*Forzamos la recarga*/
                location.reload(true);
            },
            error: function(value){
                Materialize.toast("Ha ocurrido un error al enviar los datos", 4000);
            }
        });
    }

    //Cerrar modal eliminar
    function CloseModal(){
        $('#modalDelete').modal('close');
    }
    //Cerrar modal editar
    function CloseModalEdit(){
        $('#modal1').modal('close');
    }

//Fuciones para eliminar
    function GetIdD($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/contactos/'+ $valor + '/delete', function(res){
            $('input#idget').val($valor);
        });
    }

//Funciones para eliminar
    function DeleteContacto(){
        $Id = $('input#idget').val()
        //alert($Id);
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/contactos/delete/' + $Id,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdContactos: $('input#idget').val() },
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
    }///END DeleteContactos


    
 @endsection
