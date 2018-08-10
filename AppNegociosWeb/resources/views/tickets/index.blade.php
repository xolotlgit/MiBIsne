@extends('layouts.app')

@section('content')
<div class="container">
    <!--Card Principal de Opciones-->
    <div class="card">
        <div class="card-content"></br>
            <span class="card-title activator grey-text text-darken-4"><p class="revelal-home-t">BIENVENIDO LA SECCIÓN DE TICKETS !!</p><i class="material-icons right">more_vert</i></span>
        </div>
        <div class="card-reveal"></br>
            <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
            <p class="revelal-home-t">BIENVENIDO LA SECCIÓN DE TICKETS !!</p>
            <p class="revelal-home-content">Desde esta sección podrás identificar a los usuarios ganadores de tickets, estos son otorgados aleatoriamente cuando hacen uso de la aplicación.</p>
            <p class="revelal-home-content">Si necesita ayuda puede consultar el siguiente enlace:</p>
            <p><a href="#"><i class="material-icons prefix left">computer</i>Introducción a Mi Bisne</a></p>
        </div>
        <div class="card-content">
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">event</i>
                            <input type="text" class="datepicker" id="fechmin" name="fechmin" value="">
                            <label for="icon_prefix" style="font-size:12px;">Fecha de inicio del boleto</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">event</i>
                            <input type="text" class="datepicker" id="fechmax" name="fechmax" value="">
                            <label for="icon_prefix" style="font-size:12px;">Fecha de termino del boleto</label>
                        </div>
                    </div>
                </div>
                
                <p class="card-title" id="body" style="font-size:1.2em;">.</p>
                <div id="body" class="input-field col s12 m12 l12 ">
                    <i class="material-icons prefix">short_text</i>
                    <textarea id="body" maxlength="150" class="materialize-textarea" autofocus ></textarea placeholder="Mensaje para el usuario">
                    <label for="icon_prefix" style="font-size:13px;">Descripción del contenido</label>
                </div>
               
                <div class="row">
                    <div class="col s10 offset-s1 center-align">
                        <a id="consult" class="waves-effect waves-light btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="Consulta usuarios ganadores!!" type="submit">Consultar Ganadores</a>    
                    </div>
                </div>                
            </div>
            <div id="listUsers">
            </div>
        </div>
    </div>
</div>
@endsection

@section('metodosJava')
var token = $('meta[name=csrf-token]').attr('content');
    $(document).ready(function(){
        //indicializa token de seguridad
        var token = $('meta[name=csrf-token]').attr('content');
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

        //Accion del Boton Guardar
        $('#consult').click(function(){

            $FechMin = $('input#fechmin').val();
            $arregloFecha = $FechMin.split("/");
            $anio = $arregloFecha[2];
            $mes = $arregloFecha[1];
            $dia = $arregloFecha[0];
            $FechMin = $anio+"-"+$mes+"-"+$dia;

            $FechMax = $('input#fechmax').val();
            $arregloFecha = $FechMax.split("/");
            $anio = $arregloFecha[2];
            $mes = $arregloFecha[1];
            $dia = $arregloFecha[0];
            $FechMax = $anio+"-"+$mes+"-"+$dia;

            var formtickets = new FormData();
                formtickets.append("NumMin", $('input#nummin').val());
                formtickets.append("NumMax", $('input#nummax').val());
                formtickets.append("FechMin", $FechMin);
                formtickets.append("FechMax", $FechMax);
                
            $.ajax({
                url: '/consulta/tickets/',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                data: formtickets,
                processData: false,
                contentType: false,
                success: function(data){//mensaje datos guardados
                    $("div#listUsers div").remove();
                    $(data.Valores).each(function(key, value){
                        $("div#listUsers").append('<div class="col s12 m4 l3" id="listcard"><div class="card"><div class="card-content"><span class="justificado justify">'+ value.Nombre_User + ' ' +  value.Apellidos +' </span><p class="justificado"><b>Direccion: </b> '+ value.Direccion +' </p><p class="justificado"><b>Correo Electronico: </b><p id="email'+ value.id +'"> '+ value.email +' </p></p><p class="justificado"><b>Total de Tickets: </b>'+ value.Total +'</p><div class="card-action"><div class="form-group"><button class="btn btn-secundario-s waves-effect waves-light red lighten-2" onclick="SetNotification('+ value.id +');">Enviar Notificacion</button></div></div></div></div>');
                    });
                },//mensaje error
                error: function(data){
                   Materialize.toast('A ocurrido un Error', 4000);
                }
            });//Cierre guardarN
        });//Cierre clic Botton Guardar

    });//Cierre document.ready

    //Funciones para enviar notificacion
    function SetNotification($id){
        
        $email = $('#email'+$id).text();  
        $body = $('textarea#body').val();      
        var mails = new FormData();
            mails.append("email", $email);
            mails.append("body", $body);

        if($body == null || $body.length == 0 || /^\s+$/.test($body)){
            Materialize.toast("Debes ingresar un mensaje para el usuario.", 8000);
        }else{
            $.ajax({
                url: '/notification/tickets/',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                data: mails,
                processData: false,
                contentType: false,
                success: function(data){//mensaje datos guardados
                        Materialize.toast('Notificación enviada', 4000);
                },//mensaje error
                error: function(data){
                    Materialize.toast('A ocurrido un Error', 4000);
                }
            });
        }
    }
@endsection