@extends('layouts.app')

@section('content')
<!--Modal Editar-->
<div id="modalEditar" class="modal">
    <div class="modal-content">
        <div class="cont-padd-ma">
            <h5><b>EDITAR ANUNCIO</b></h5> </br>
            <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
            <div class="form-group">
                <label>Fecha de inicio del anuncio</label> 
                <div class="input-field col s6 m6 l3">
                    <i class="material-icons prefix">event</i>
                    <input type="text" class="" maxlength="100"  id="Nombre_Anuncio" name="Nombre_Anuncio" value="" required autofocus>
                </div>
            </div>
            
            <div class="form-group">
                <label>Fecha de inicio del anuncio</label> 
                <div class="input-field col s6 m6 l3">
                    <i class="material-icons prefix">event</i>
                    <input type="text" class="datepicker" id="Fecha_Inicio" name="Fecha_Inicio" value="">
                </div>
            </div>
            <div class="form-group">
                <label>Fecha de termino del anuncio</label>
                <div class="input-field col s6 m6 l3">
                    <i class="material-icons prefix">event</i> 
                    <input type="text" class="datepicker" id="Fecha_Fin" name="Fecha_Fin">
                </div>
            </div>            
            <div class="form-group">
                <input id="status" type="checkbox" class="filled-in" />
                <label for="status">Status del anuncio</label>
            </div></br>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <a class="waves-effect waves-light btn modal-trigger" onclick="SetDatosAct();" href="#modalEditar">Guardar cambios</a>
                    <a class=" btn btn-secundario" onclick="CloseModalEdit();" href="#modalEditar"> Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin del modal editar-->                   
<!-- Modal Delete -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
        <h5>¿Esta seguro que desea eliminar este registro?</h5>
        <p class="justify">Una vez eliminado este anuncio no podra recuperarlo. Esta seguro que desea continuar?</p>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
    </div>
    <div class="modal-footer">
        <button class="waves-effect btn" id="Eliminar" onclick="DeleteAnuncio();" style="background-color:#E57373;">Eliminar<i class="material-icons prefix right">delete</i></button>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="CloseModal();">Cancelar</a>
    </div>
</div>  
<!--Fin del modal delete-->

<div></br> </br></div>
<div class="container">
    <div class="row">
        <div class="col s12 m12  l12">
          <div class="card">
            <div class="card-content">
             <span class="card-title col s12 m12 l12"><b>ANUNCIOS</b></span></br> </br>
                <div class="col s12">
                    <div class="row">
                        <table id="buscausuarios" class="bordered highlight">
                            <thead>
                                <div class="input-field col s12 m12 l12">
                                    <i class="material-icons prefix">search</i>
                                    <input type="text" id="autocomplete" onkeyup="complete();" class="autocomplete" autofocus class="autocomplete">
                                    <label for="autocomplete-input">Busca un anuncio en especifico</label>
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
                                    <input disabled  type="text" id="Nombre_Anuncio" name="Nombre_Servicio" class="form-control">
                                </div>
                            </div>
                        </table> 
                    </div>
                </div>

                <div class="row">
                    <div id="listadoAnuncios"> 
                    @foreach($anuncios as $anuncio)
                        <div class="col s12 m4 l3">
                            <div class="card">
                                <div class="card-image waves-effect waves-block waves-light" style="height:150px;">
                                    <img class="activator" src="{{$anuncio->Imagen_Url}}">
                                </div>
                                <div class="card-content">
                                    <p><b class="t-anuncio activator grey-text text-darken-4">{{$anuncio->Nombre_Negocio}}</b></p></br>
                                    <button class="btn btn-secundario-s waves-effect waves-light red lighten-2 modal-trigger" value"{{$anuncio->IdAnuncio}}" onclick="GetDatos({{$anuncio->IdAnuncio}});" href="#modalEditar">Editar</button>
                                    <button class="waves-effect waves-light red darken-2 btn modal-trigger" value"{{$anuncio->IdAnuncio}}" onclick="GetIdD({{$anuncio->IdAnuncio}});" id="Eliminar" href="#modalDelete">Eliminar</button>
                                    <input id="id" type="number" class="form-control hide" name="id" value="{{$anuncio->IdAnuncio}}">
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4"><b class="txt-t-cr">{{$anuncio->Nombre_Negocio}}</b><i class="material-icons prefix right">close</i></span></br>
                                    <p class="t-anuncio-cr">Anuncio:{{$anuncio->Nombre_Anuncio}}</p></br>
                                    <p class="txt-a"><b>Propietario:</b> {{$anuncio->Nombre_User . ' ' . $anuncio->Apellidos}}</p>
                                    <p class="txt-a"><b>Fecha de Inicio:</b> {{$anuncio->Fecha_Inicio}}</p>
                                    <p class="txt-a"><b>Fecha de Termino:</b> {{$anuncio->Fecha_Fin}}</p>
                                </div>
                            </div>
                        </div>     
                        @endforeach
                    </div>
                 </div><!-- End row -->
                 <!--Paginacion-->
                    <center><b>{{ $anuncios->links() }}</b></center>
                 <!--Fin Paginacion -->
             </div>
          </div>
       </div>
   </div>
</div>
@endsection

<!--Instancia para metodos Java-->
@section('metodosJava')
    $(document).ready(function(){
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

    //indicializa Calendarios
    $('.datepicker').pickadate({
        format: 'dd/mm/yyyy',
        selectYears: 99,
        selectMonths: true,
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Aceptar',
        closeOnSelect: false, // Close upon selecting a date,
        labelMonthNext: 'Siguiente',
        labelMonthPrev: 'Anterior',
        labelMonthSelect: 'Seleccionar Mes',
        labelYearSelect: 'Seleccionar Año',
        monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: [ 'Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado' ],
        weekdaysShort: [ 'Dom', 'Lun', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa' ],
        weekdaysLetter: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
         
    });//Cierre indicializacion Calendarios

    function CloseModal(){
        $('#modalDelete').modal('close');
    }//END Close Modal 

    function GetIdD($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/anuncios/'+ $valor + '/delete', function(res){
            $('input#idget').val($valor);
        });
    }

    function DeleteAnuncio(){
        $Id = $('input#idget').val()
        alert($Id);
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/anuncios/delete/' + $Id,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdAnuncio: $('input#idget').val() },
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

    //Funciones para editar
    function GetDatos($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/anuncios/'+ $valor + '/edit', function(res){
            $('input#idget').val($valor);
            $('input#Nombre_Anuncio').val(res.Nombre_Anuncio);

            $Fecha_Inicio = res.Fecha_Inicio;
            $arregloFecha = $Fecha_Inicio.split("-");
            $anio = $arregloFecha[2];
            $mes = $arregloFecha[1];
            $dia = $arregloFecha[0];
            $Fecha_Inicio = $anio+"/"+$mes+"/"+$dia;
            $('input#Fecha_Inicio').val($Fecha_Inicio);

            $Fecha_Fin = res.Fecha_Fin;
            $arregloFecha = $Fecha_Fin.split("-");
            $anio = $arregloFecha[2];
            $mes = $arregloFecha[1];
            $dia = $arregloFecha[0];
            $Fecha_Fin = $anio+"/"+$mes+"/"+$dia;
            $('input#Fecha_Fin').val($Fecha_Fin);
            if(res.bitStatus == 1 ){
                $(':checkbox').prop('checked', true).attr('checked', 'checked');
            }else{
                $(':checkbox').prop('checked', false).removeAttr('checked');
            }
        });
    }

    //Funciones para editar
    function SetDatosAct(){
        $btn = $('input#idget').val();

        $Fecha_Inicio = $('input#Fecha_Inicio').val();
            $arregloFecha = $Fecha_Inicio.split("/");
            $anio = $arregloFecha[2];
            $mes = $arregloFecha[1];
            $dia = $arregloFecha[0];
            $Fecha_Inicio = $anio+"/"+$mes+"/"+$dia;
            
            $Fecha_Fin =  $('input#Fecha_Fin').val()
            $arregloFecha = $Fecha_Fin.split("/");
            $anio = $arregloFecha[2];
            $mes = $arregloFecha[1];
            $dia = $arregloFecha[0];
            $Fecha_Fin = $anio+"/"+$mes+"/"+$dia;

            if( $('input#status').prop('checked') ) {
                $Status = 1;
            }else{
                $Status = 0;
            }

        $.ajax({
            url: '/anuncios/' + $btn,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { Nombre_Anuncio: $('input#Nombre_Anuncio').val(), Fecha_Inicio: $Fecha_Inicio, Fecha_Fin: $Fecha_Fin, Status: $Status},
            success: function(value){
                Materialize.toast(value.mensaje, 4000);
                $('#modalEditar').modal('close');
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

    function CloseModaledit(){
        $('#modalEditar').modal('close');
    }//END Close Modal Detalles

    //Busqueda de servicios
    function complete() {
        var token = $('meta[name=csrf-token]').attr('content');
        $anuncio =$('input#autocomplete').val();
        if ($anuncio == "" || $anuncio == " "){
            $('input#autocomplete').focus();
            $('div#listadoAnuncios').show();
            $("#lstServ div").remove();
        }else{
            $.get('/anuncios/autoanuncio/'+ $anuncio + '/', function(res){
                $('div#listadoAnuncios').hide();
                $("#lstServ div").remove();
                $(res).each(function(key, value){
                    $("div#lstServ").append('<div class="col s12 m4 sm4 lm4 l3" id="listcard"><div class="card responsive" style="max-height:400px;"><div class="card-image waves-effect waves-block waves-light" style="height:150px;"><img class="responsive-img" src="'+ value.Imagen_Url +'"></div><div class="card-content"><input id="id" type="number" class="form-control hide" name="id" value="'+ value.IdAnuncio +'"><b><span class="t-anuncio-cr justify">'+ value.Nombre_Negocio +' </span></b></br><b><span class="t-anuncio-cr justify" style="font-size:12px; color:#E57373;">'+ value.Nombre_Anuncio +' </span></b></br><p class="justificado"><b>Fecha de inicio: </b> '+ value.Fecha_Inicio +' </p><p class="justificado"><b>Fecha de Fin: </b> '+ value.Fecha_Fin +' </p><div class="card-action"><div class="form-group" style="margin-left:3px;"><button class="btn btn-secundario-s waves-effect waves-light red lighten-2 modal-trigger" value"'+ value.IdAnuncio +'" onclick="GetDatos('+ value.IdAnuncio +');" href="#modalEditar">Editar</button><button class="waves-effect btn modal-trigger" value"'+ value.IdAnuncio +'" onclick="GetIdD('+ value.IdAnuncio +');" id="Eliminar" href="#modalDelete" >Eliminar</button></div></div></div></div>');
                });
            });
        }
    }//Cierre Busqueda de servicios

 @endsection