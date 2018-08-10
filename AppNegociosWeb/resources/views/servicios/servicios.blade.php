@extends('layouts.app')

@section('content')
<!--Modal de Editar-->
<div id="modal1" class="modal">
    <div class="modal-content"></br>
        <h5>EDITAR SERVICIO</h5>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
           <div class="form-group">
              <label class="col s12 m12 l12"  style="font-size:14px;">Negocio</label>
              <div class="input-field col s12 m12 l12">
                <div>
                    <select id="IdNegocio" name="IdNegocio"  class="browser-default">
                    <option value="" disabled selected style="font-size:14px;" autofocus>Selecciona un negocio</option>
                        @foreach($negocio as $nego)
                            <option value="{{$nego->IdNegocio}}">{{$nego->Nombre_Negocio}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          </div></br>

           <div class="form-group{{ $errors->has('nombreservicio') ? ' has-error' : '' }}">
              <div class="input-field ">
                  <i class="material-icons prefix">edit</i>
                  <input id="nombreservicio" type="text" maxlength="50" class="form-control" name="nombreservicio" value="{{ old('nombreservicio') }}" required autofocus >
                   @if ($errors->has('nombreservicio'))
                     <span class="help-block">
                       <strong>{{ $errors->first('nombreservicio') }}</strong>
                     </span>
                   @endif
                  <label for="icon_prefix" style="font-size:13px;">Nombre del servicio</label>
              </div>
          </div>
                       
          <div class="form-group{{ $errors->has('descripcionservicio') ? ' has-error' : '' }}">
             <div class="input-field ">
                 <i class="material-icons prefix">short_text</i>
                 <textarea id="descripcionservicio" type="text" maxlength="250" class="materialize-textarea" name="descripcionservicio"  value="{{ old('descripcionservicio') }}" required autofocus></textarea>
                 @if ($errors->has('descripcionservicio'))
                   <span class="help-block">
                     <strong>{{ $errors->first('descripcionservicio') }}</strong>
                   </span>
                 @endif
                 <label for="icon_prefix" style="font-size:13px;">Descripción del servicio</label>
             </div>
         </div> 

         <div class="form-group{{ $errors->has('costoservicio') ? ' has-error' : '' }}">
             <div class="input-field ">
                <i class="material-icons prefix">credit_card</i>
                <input id="costoservicio" type="number" class="form-control" name="costoservicio" value="{{ old('costoservicio') }}" required autofocus >
                 @if ($errors->has('costoservicio'))
                   <span class="help-block">
                     <strong>{{ $errors->first('costoservicio') }}</strong>
                   </span>
                  @endif
                <label for="icon_prefix" style="font-size:13px;">Costo del servicio</label>
               </div>
          </div></br>
        
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

<!-- Modal Delete -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
       <h5>¿Esta seguro que desea eliminar este servicio?</h5>
       <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
    </div>
    <div class="modal-footer">
       <button class="waves-effect btn" id="Eliminar" onclick="DeleteServicio();" style="background-color:#E57373;">Eliminar<i class="material-icons prefix right">delete</i></button>
       <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="CloseModal();">Cancelar</a>
    </div>
</div>      

<!--Contenedor principal-->
<div></br> </br></div>
<div class="container">
@if(session()->has('msg'))
 <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@endif
@if(session()->has('msgerror'))
 <div class="alert alert-warning" role="alert">{{ session('msgerror')}}</div>
@endif
  <div class="row">
     <div class="col s12 m12  l12  ">
          <div class="card">
            <div class="card-content"></br>
                <div class="cont-padd"><span class="card-title s9 l11 m11"><b>SERVICIOS</b></span></div>
                    <div class="col s12">
                        <div class="row">
                            <table id="buscausuarios" class="bordered highlight">
                                <thead>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">search</i>
                                        <input type="text" id="autocomplete" onkeyup="complete();" class="autocomplete" autofocus class="autocomplete">
                                        <label for="autocomplete-input">Introduce el nombre del servicio o de su negocio según lo que desees buscar</label>
                                    </div>
                                </thead>
                                <div id="lstServ">
                                </div>
                            </table> 
                        </div>
                        <div class="row hide" id="userid">
                            <table id="userselec" class="bordered highlight">
                                <div id="lstServ2">
                                    <div class="input-field col s12 m12 l12" id="listcard">
                                        <input disabled  type="text" id="id" name="id" class="form-control hide">
                                        <input disabled  type="text" id="Nombre_Servicio" name="Nombre_Servicio" class="form-control">
                                    </div>
                                </div>
                            </table> 
                        </div>
                    </div>

                    <div class="row">
                        <div id="listadoServicios">
                            @foreach($servicios as $serv)
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-stacked">
                                        <div style="height:125px; overflow-y: scroll;">
                                            <div class="card-content">
                                                <span class="card-title" style="font-size:20px;">{{$serv->Nombre_Servicio}}</span>
                                                <p class="justificado"><b>Negocio:</b>{{$serv->Nombre_Negocio}}</br>
                                                <b>Descripción:</b>{{$serv->Descripcion_S}}</br>
                                                <b>Costo:</b>{{$serv->Costo}}</p>
                                                <input id="id" type="number" class="form-control hide" name="id" value="{{$serv->IdServicio}}">
                                            </div>
                                        </div>
                                        <div class="card-action">
                                            <button class="waves-effect waves-light btn modal-trigger" value"{{$serv->IdServicio}}" onclick="GetDatos({{$serv->IdServicio}});" href="#modal1" style="background-color:#E57373;">Editar <i class="material-icons prefix right">edit</i></button>
                                            <button class="waves-effect waves-light red darken-2 btn modal-trigger" value"{{$serv->IdServicio}}" onclick="GetIdD({{$serv->IdServicio}});" id="Eliminar" href="#modalDelete">Eliminar<i class="material-icons prefix right">delete</i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div><!-- End row -->
                    <!-- Paginación -->
                    <center><b>{{ $servicios->links() }}</b></center>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!--Instancia para metodos Java-->
@section('metodosJava')
    $(document).ready(function(){
        //indicializa token de seguridad
        var token = $('meta[name=csrf-token]').attr('content');

        //indicializa autocomplete
        $('input.autocomplete').autocomplete({
            data: {
              
            },
            limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
            onAutocomplete: function(val) {
              // Callback function when value is autcompleted.
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
        });//Cierre indicializacion auntocomplete
        
    });

    function GetDatos($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/servicios/'+ $valor + '/edit', function(res){
            $('input#idget').val($valor);
            $('#IdNegocio').val(res.IdNegocio);
            $('input#nombreservicio').val(res.Nombre_Servicio);
            $('textarea#descripcionservicio').val(res.Descripcion_S);
            $('input#costoservicio').val(res.Costo);
        });
    }
    
    function SetDatosAct(){
        $btn = $('input#idget').val();
        $.ajax({
            url: '/servicios/' + $btn,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdNegocio: $('#IdNegocio').val(), Nombre_Servicio: $('input#nombreservicio').val(),Descripcion_S: $('textarea#descripcionservicio').val(),Costo: $('input#costoservicio').val() },
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

    function MessageReturn(){
        $.ajax({
            url: 'ServiciosController.php',
            type: 'GET',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            success: function(value){
                Materialize.toast(value.mensaje, 4000);
                /*Recargamos desde caché*/
                location.reload();
                /*Forzamos la recarga*/
                location.reload(true);
            },
            error: function(valie){
                Materialize.toast("Ha ocurrido un error al guardar los datos", 4000);
            }
        });
    }

    function CloseModal(){
        $('#modalDelete').modal('close');
    }//END Close Modal 

    function GetIdD($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/servicios/'+ $valor + '/delete', function(res){
            $('input#idget').val($valor);
        });
    }

    function DeleteServicio(){
        $Id = $('input#idget').val()
        //alert($Id);
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/servicios/delete/' + $Id,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdServicio: $('input#idget').val() },
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
    }///END DeleteServicio

    //Busqueda de servicios
    function complete() {
        var token = $('meta[name=csrf-token]').attr('content');
        $usuario =$('input#autocomplete').val();
        if ($usuario == "" || $usuario == " "){
            $('input#autocomplete').focus();
            $('div#listadoServicios').show();
            $("#lstServ div").remove();
        }else{
            $.get('/servicios/autoservice/'+ $usuario + '/', function(res){
                $('div#listadoServicios').hide();
                $("#lstServ div").remove();
                $(res).each(function(key, value){
                    $("div#lstServ").append('<div class="col s12 m6 l6" id="listcard"><div class="card horizontal"><div class="card-stacked"><div class="card-content"><input id="id" type="number" class="form-control hide" name="id" value="{{$serv->IdServicio}}"><span class="card-title justify">'+ value.Nombre_Servicio +' </span><p class="justificado"><b>Negocio:</b>'+ value.Nombre_Negocio +' </p><p class="justificado"><b>Descripción: </b> '+ value.Descripcion_S +' </p></br> <button class="waves-effect waves-light btn modal-trigger" value"'+ value.IdServicio +'" onclick="GetDatos('+ value.IdServicio +');" href="#modal1" style="background-color:#E57373;">Editar <i class="material-icons prefix right">edit</i></button><button class="waves-effect btn modal-trigger" value"'+ value.IdServicio +'" onclick="GetIdD('+ value.IdServicio +');" id="Eliminar" href="#modalDelete">Eliminar<i class="material-icons prefix right">delete</i></button></div></div></div>');
                });
            });
        }
    }//Cierre Busqueda de servicios


 @endsection

