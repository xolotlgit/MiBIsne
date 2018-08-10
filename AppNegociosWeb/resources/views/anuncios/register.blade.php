@extends('layouts.app')
  
@section('content')
<div></br> </br></div>
<div class="container">
    <div class="row">
        <div class="col s12 m6  l6 offset-m3 offset-l3">
            <div class="card">
                <div class="card-content">
                   <div class="cont-padd"></br>
                    <span class="card-title"><b>REGISTRAR ANUNCIOS</b></span> </br>
                        <div class="panel-body">
                           <form class="form-horizontal" id="formAnuncios" role="form" method="POST" action="{{url('anuncios')}}" onsubmit="return validarFormulario()">
                            {{ csrf_field() }}
                     
                            <form class="form-horizontal" id="formAnuncios" >
                            <label class="col s12 m12 l12"  style="font-size:14px;">Negocio</label></br>
                            <div class="form-group">
                                <div class="input-field col s12">
                                    <div class="file-field input-field">
                                        <div>
                                            <select id="IdNegocio" name="IdNegocio"  class="browser-default">
                                                <option value="" disabled selected style="font-size:14px;" autofocus>Selecciona un negocio</option>
                                                @foreach($negocio as $nego)
                                                <option value="{{$nego->IdNegocio}}">{{$nego->Nombre_Negocio}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                           <div> </br></br></br></br>

                            <label for="icon_prefix" style="font-size:13px;">Nombre del anuncio</label>
                            <div class="form-group{{ $errors->has('Nombre_Anuncio') ? ' has-error' : '' }}">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">edit</i>
                                        <input id="Nombre_Anuncio" type="text" maxlength="100" class="form-control" name="Nombre_Anuncio" value="{{ old('Nombre_Anuncio') }}" required  >
                                        @if ($errors->has('Nombre_Anuncio'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('Nombre_Anuncio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        
                            <label>Fecha de inicio y de termino del anuncio</label> 
                            <div class="form-group">
                                <div class="input-field col s12 m12 l6">
                                    <i class="material-icons prefix">event</i>
                                    <input type="text" class="datepicker" id="Fecha_Inicio" name="Fecha_Inicio" value="{{$mesInicio}}">
                                </div>
                            </div>

                        
                            <div class="form-group">
                                <div class="input-field col s12 m12 l6">
                                    <i class="material-icons prefix">event</i>
                                    <input type="text" class="datepicker" id="Fecha_Fin" name="Fecha_Fin">
                                </div>
                            </div>

                            <label for="icon_prefix">Seleccionar anuncio</label>
                                <div class="file-field input-field">
                                   <div>
                                        <span class="btn col s12 m12 l5" style="background-color:#9e9e9e;">Buscar anuncio</span>
                                        <input type="file" id="file" name="file">
                                   </div>
                                    <div class="file-path-wrapper" >
                                        <input class="file-path validate" type="text" value="{{ old('image') }}" required  >
                                    </div>
                                </div>
                            <div>
                            <div class="col-md-12 col-md-offset-12">
                                <a class="btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="Guardar Anuncio!!" id="GuardarA" type="submit">Guardar</a>
                                <a class=" btn" href="/anuncios"  style="background-color:#E57373;"> Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
             </div>
           </div>
        </div>
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
        var token = $('meta[name=csrf-token]').attr('content');//token laravel
        $('#GuardarA').click(function(){          
            //Instancia a FormData con el formulario
            var DataAnuncio = new FormData();
            DataAnuncio.append("Nombre_Anuncio", $('input#Nombre_Anuncio').val());
            DataAnuncio.append("IdNegocio", $('#IdNegocio').val());
            DataAnuncio.append("Fecha_Inicio", $('input#Fecha_Inicio').val());
            DataAnuncio.append("Fecha_Fin", $('input#Fecha_Fin').val());
            DataAnuncio.append("file", document.getElementById("file").files[0]);

            var cmbNegocio = document.getElementById('IdNegocio').selectedIndex;
            var txtNombreAnuncio = document.getElementById('Nombre_Anuncio').value;
            var txtFecha_Inicio = document.getElementById('Fecha_Inicio').value;
            var txtFecha_Fin = document.getElementById('Fecha_Fin').value;
            var txtFile = document.getElementById('file').value;

            //Test comboBox Negocios
            if(cmbNegocio == null || cmbNegocio == 0){
                Materialize.toast('Atencion: Debe seleccionar el negocio al que le pertenece el anuncio.', 8000);
                return false;
            }
        
            //Test campo obligatorio
            if(txtNombreAnuncio == null || txtNombreAnuncio.length == 0 || /^\s+$/.test(txtNombreAnuncio)){
                Materialize.toast('Atención: El nombre del anuncio no puede ir vacío.', 8000);
                return false;
            }

            //Test campo obligatorio
            if(txtFecha_Inicio == null || txtFecha_Inicio.length == 0 || /^\s+$/.test(txtFecha_Inicio)){
                Materialize.toast('Atención: Introduzca una fecha', 8000);
                return false;
            }

            //Test campo obligatorio
            if(txtFecha_Fin == null || txtFecha_Fin.length == 0 || /^\s+$/.test(txtFecha_Fin)){
                Materialize.toast('Atención: Introduzca una fecha', 8000);
                return false;
            }

            //Test campo obligatorio
            if(txtFile == null || txtFile.length == 0 || /^\s+$/.test(txtFile)){
                Materialize.toast('Asegurese de haber seleccionado la imagen para su anuncio', 8000);
                return false;
            }

        $.ajax({
                url: '/anuncios/save',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                data: DataAnuncio,
                processData: false,
                contentType: false,
                success: function(data){//mensaje datos guardados
                    Materialize.toast(data.mensaje, 4000);
                    document.getElementById("formAnuncios").reset();
                },//mensaje error
                error: function(data){
                   Materialize.toast('A ocurrido un Error', 4000);
                  
                }
            });//Cierre guardarN
        });//Cierre clic Botton Guardar

    });//Cierre document.ready

@endsection
