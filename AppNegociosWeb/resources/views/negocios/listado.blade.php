@extends('layouts.app')

@section('content')

<div></br></div>
<div class="container">
   <div class="row">
      <div class="col s12">
          <div class="card card">
             <div class="card-content hoverable">
               </br> <span class="card-title"><b>LISTADO DE NEGOCIOS</b></span></br>
                    <div class="panel-body">
                    <!--Contenedor Principal--> 
                        <div class="col s12">
                            <div class="row">
                                <table id="buscausuarios" class="bordered highlight">
                                    <thead>
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">search</i>
                                            <input type="text" id="autocomplete" onkeyup="complete();" class="autocomplete" autofocus class="autocomplete">
                                            <label for="autocomplete-input">Nombre del Negocio</label>
                                        </div>
                                    </div>
                                </div>
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
                                            <input disabled  type="text" id="Nombre_Negocio" name="Nombre_Negocio" class="form-control">
                                        </div>
                                    </div>
                                </table> 
                            </div>
                        </div>
                        <div class="row">
                            <div id="listadoNegocios">
                            @foreach($negocios as $nego)
                                <div class="col s12 m6 l6">
                                    <div class="card horizontal">
                                        <div class="card-image col s12 m4 l4">
                                            <img src="/images/Menu/negociolista.png">
                                        </div>
                                        <div class="card-stacked">
                                            <div class="card-content">
                                                <div class="pdd-ttl-cardLN"><span class="titulo activator grey-text text-darken-4">{{$nego->Nombre_Negocio}}</span></div>
                                            </div>
                                            <div class="card-action">
                                                <p><a class="waves-effect waves-light btn" onclick="GetNegocio({{$nego->IdNegocio}});">Detalles</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                           </div>
                         </div><!--end row-->
                        <!--Paginacion-->
                        <center><b>{{ $negocios->links() }}</b></center>
                        <!--Fin Paginacion -->
                       <!-- Etiquetas de Cierre del contenedor principal-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin de Contenedor Principal-->
<!--Modal de editar datos-->
<div id="modal1" class="modal ">
   <div class="modal-content">
      <div class="row">
            <div class="card">
                <div class="card-content">
                    <div class="cab-descripcion">
                        <p class="card-title"><b id="NombreN"></b></p>
                        <div id="Nombre_Negocio" class="input-field col s12 m6 l6 hide">
                            <i class="material-icons prefix">business</i>
                            <input id="Nombre_Negocio" type="text" maxlength="30" class="form-control" name="Nombre_Negocio" value="" autofocus />
                            <label for="icon_prefix" style="font-size:12px;">Nombre de negocio</label>
                        </div>
                        <p class="card-title" id="Descripcion" style="font-size:1.2em;">.</p>
                        <div id="Descripcion" class="input-field col s12 m12 l12 ">
                            <i class="material-icons prefix">short_text</i>
                            <textarea id="Descripcion_N" maxlength="255" class="materialize-textarea" autofocus ></textarea placeholder="Ingresa una pequeña descripción sobre el giro de su negocio">
                            <label for="icon_prefix" style="font-size:13px;">Descripción</label>
                        </div>
                    </div>
                </div>
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab"><a class="active" href="#test4">DATOS GENERALES</a></li>
                        <li class="tab"><a href="#test5">REDES SOCIALES</a></li>
                        <li class="tab"><a href="#test6">IMAGENES</a></br></br></li></br>
                    </ul>
                </div>
                <div class="card-content grey lighten-4">
                    <div id="test4">
                        <div class="list-neg">
                            <ul class="collection" id="datos-general-coll">
                                <li class="collection-item">
                                    <input disabled  type="text" id="IdNegocio" name="IdNegocio" class="form-control hide">
                                    <p id="1"><b>Dirección:</b><i class="material-icons left">short_text</i></p><p id="Direccion"></p>
                                </li>
                                <li class="collection-item">
                                    <p id="2"><b>Horarios:</b><i class="material-icons left">timer</i></p><p  id="Horario"></p>
                                </li>
                                <li class="collection-item">
                                   <p id="3"><b>Teléfono Fijo:</b><i class="material-icons left">phone</i></p><p  id="TelefonoF"></p>
                                </li>
                                <li class="collection-item">
                                   <p id="4"><b>Teléfono Móvil:</b><i class="material-icons left">phone_android</i></p><p  id="TelefonoM"></p>
                                </li>
                                <li class="collection-item">
                                   <p id="5"><b>Correo Electronico:</b><i class="material-icons left">mail</i></p><p  id="Correo"></p>
                                </li>
                                <li class="collection-item">
                                   <p id="fecha_inicio"><b>Fecha de inicio de suscripción:</b> <i class="material-icons left">event</i></p><p  id="IniSuscrip"></p>
                                </li>
                                <li class="collection-item">
                                   <p id="fecha_fin"><b>Fecha de fin de suscripción:</b><i class="material-icons left">event</i></p><p  id="FinSuscrip"></p>
                                </li>
                            </ul>
                            
                            <div id="Direccion_N" class="input-field">
                                <i class="material-icons prefix">edit</i>
                                <input id="Direccion_N" type="text" maxlength="80" class="form-control" name="Direccion_N" value="" autofocus >
                                <label for="icon_prefix" style="font-size:12px;">Dirección</label>
                            </div>
                            <div id="Horario" class="input-field">
                                <i class="material-icons prefix">timer</i>
                                <input id="Horario" type="text" maxlength="100" class="form-control" name="Horario" value="" autofocus >
                                <label for="icon_prefix" style="font-size:12px;">Horario</label>
                            </div>
                            <div id="Telefono_F" class="input-field ">
                                <i class="material-icons prefix">phone</i>
                                <input id="Telefono_F" type="text" maxlength="10" class="form-control" name="Telefono_F" value="" autofocus >
                                <label for="icon_prefix" style="font-size:12px;">Teléfono Fijo</label>
                            </div>
                            <div id="Telefono_M" class="input-field">
                                <i class="material-icons prefix">phone_android</i>
                                <input id="Telefono_M" type="text" maxlength="10" class="form-control" name="Telefono_M" value="" autofocus>
                                <label for="icon_prefix" style="font-size:12px;">Teléfono alternativo</label>
                            </div>
                            <div id="Email_N" class="input-field">
                                <i class="material-icons prefix">mail</i>
                                <div class="list-negocios"><i class="material-icons prefix bottom"></i><input id="Email_N" type="email" maxlength="60" class="form-control" name="Email_N" value="" autofocus placeholder="Email"></div>
                            </div>
                            <div id="Fecha_I" class="input-field">
                                <i class="material-icons prefix">event</i> 
                                <input type="text" class="datepicker" name="IniSuscrip" value="" id="IniSuscrip">
                                <label for="icon_prefix" style="font-size:12px; text-align:right;">Fecha de inicio de suscripción</label>
                            </div>
                            <div id="Fecha_F" class="input-field"> 
                                <i class="material-icons prefix">event</i> 
                                <input type="text" class="datepicker" name="FinSuscrip" value="" id="FinSuscrip">
                                <label for="icon_prefix" style="font-size:12px; text-align:right;">Fecha de termino de suscripción</label>
                            </div>
                        </div>
                    </div>
                    <div id="test5">
                        <div class="list-neg">
                            <ul class="collection" id="datos-redes-coll">
                                <li class="collection-item">
                                    <p id="6">Sitio Web:<i class="material-icons left">laptop</i></p><p  id="Sitio"></p>
                                </li>
                                <li class="collection-item">
                                    <p id="7">Facebook:<i class="material-icons left">thumb_up</i></p><p id="Face"></p>
                                </li>
                                <li class="collection-item">
                                    <p id="8">Twitter:<i class="fa fa-twitter  left small"></i></p><p  id="Tuiter"></p>
                                </li>
                                <li class="collection-item">
                                    <p id="9">Instagram:<i class="fa fa-instagram left small"></i></p><p  id="Instagram"></p>
                                </li>
                                <li class="collection-item">
                                    <p id="10">Otra red social:<i class="material-icons left">create</i></p><p  id="Otra"></p>
                                </li>
                            </ul>
                            
                            <div id="Sitio_Web" class="input-field">
                                <i class="material-icons prefix">laptop</i>
                                <input id="Sitio_Web" type="url" maxlength="150" class="form-control" name="Sitio_Web" value="" autofocus>
                                <label for="icon_prefix" style="font-size:12px;">Sitio web</label>
                            </div>
                            <div id="Facebook" class="input-field">
                                <i class="material-icons prefix">thumb_up</i>
                                <input id="Facebook" type="text" class="form-control" name="Facebook" value="" autofocus>
                                <label for="icon_prefix" style="font-size:12px;">Facebook</label>
                            </div>
                            <div id="Twitter" class="input-field">
                                <i class="material-icons prefix">face</i>
                                <input id="Twitter" type="text" maxlength="100" class="form-control" name="Twitter" value="" autofocus >
                                <label for="icon_prefix" style="font-size:12px;">Twitter</label>
                            </div>
                            <div id="Instagram" class="input-field">
                                <i class="material-icons prefix">favorite</i>
                                <input id="Instagram" type="text" maxlength="150" class="form-control" name="Instagram" value="" autofocus>
                                <label for="icon_prefix" style="font-size:12px;">Instagram</label>
                            </div>
                            <div id="Otra_Red" class="input-field">
                                <i class="material-icons prefix">edit</i>
                               <div class="list-negocios"><i class="material-icons prefix bottom"></i><input id="Otra_Red" type="text" maxlength="100" class="form-control" name="Otra_Red" value="" autofocus ></div>
                               <label for="icon_prefix" style="font-size:12px;">Otra red social</label>
                            </div>
                        </div>
                    </div>
                    <div id="test6">
                        <!--Inicio del row-->
                        <div class="row">
                            <!--Inicio del card para imagenes-->
                            <div class="col s12 m4 l4">
                                <div class="card">
                                    <div class="card-image">
                                        <img id="img1" src="/images/Negocios/Abarrotes La Subidita_1_2.jpg">
                                    </div>
                                </div>
                            </div><!--Fin card imagenes-->
                            <!--Inicio del card para imagenes-->
                            <div class="col s12 m4 l4">
                                <div class="card">
                                    <div class="card-image">
                                        <img id="img2" src="/images/Negocios/Abarrotes La Subidita_1_2.jpg">
                                    </div>
                                </div>
                            </div><!--Fin card imagenes-->
                            <!--Inicio del card para imagenes-->
                            <div class="col s12 m4 l4">
                                <div class="card">
                                    <div class="card-image">
                                        <img id="img3" src="/images/Negocios/Abarrotes La Subidita_1_2.jpg">
                                    </div>
                                </div>
                            </div><!--Fin card imagenes-->
                        </div><!--Fin del row-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group right">
                    <button class="waves-effect btn" id="Guardar" onclick="SaveNegocio();" style="background-color:#E57373;">Guardar Cambios</button>
                    <button class="waves-effect btn" id="Editar" onclick="EditNegocio();" style="background-color:#E57373;">Editar Datos<i class="material-icons right">edit</i></button>
                    <button class="waves-effect btn" id="Eliminar" onclick="DeleteNegocio();">Eliminar<i class="material-icons prefix right">delete</i></button>
                    <a class="btn tooltipped" id="Cerrar" onclick="CloseModal();" data-position="bottom" data-delay="50" data-tooltip="Regresar al menu principal"><i class="material-icons right">close</i>Cerrar</a>
                    <a class="btn tooltipped" id="Cancelar" onclick="CloseModal();" data-position="bottom" data-delay="50" data-tooltip="Regresar al menu principal"><i class="material-icons right">close</i>Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin del modal-->

@endsection

@section('metodosJava')
var token = $('meta[name=csrf-token]').attr('content');
    $(document).ready(function(){
        //indicializa token de seguridad
        var token = $('meta[name=csrf-token]').attr('content');
        /*indicializa Calendarios
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
            
        });Cierre indicializacion Calendarios*/
        
        $click = 0 ;
        $("html").click(function() {
            if ($click == 1){
                //alert("Cierre modal");
            }
        });

    });//Cierre document.ready

    function GetNegocio($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $.get('/detalles/negocio/'+ $valor , function(res){
            $(res).each(function(key, value){
                $('#modal1').modal('open');
                //Value para Etiquetas p/b
                $('input#IdNegocio').val(value.IdNegocio);
                $('b#NombreN').text(value.Nombre_Negocio);
                $('p#Descripcion').text(value.Descripcion);
                $('p#Direccion').text(value.Direccion_N);
                $('p#Horario').text(value.Horario);
                $('p#TelefonoF').text(value.Telefono_F);
                $('p#TelefonoM').text(value.Telefono_M);
                $('p#Correo').text(value.Email_N);
                $('p#IniSuscrip').text(value.Fech_Ini_Suscrip);
                $('p#FinSuscrip').text(value.Fech_Fin_Suscrip);
                $('p#Sitio').text(value.Sitio_Web);
                //$("a#linkfacebook").text(value.Facebook);
                $('p#Face').text(value.Facebook);
                $('p#Tuiter').text(value.Twitter);
                $('p#Instagram').text(value.Instagram);
                $('p#Otra').text(value.Otra_Red);
                $('#img1').attr("src",value.Imagen1);
                $('#img2').attr("src",value.Imagen2);
                $('#img3').attr("src",value.Imagen3);

                
                //Value para inputs editables
                $('input#Nombre_Negocio').val(value.Nombre_Negocio);
                $('textarea#Descripcion_N').val(value.Descripcion);
                $('input#Direccion_N').val(value.Direccion_N);
                $('input#Horario').val(value.Horario);
                $('input#Telefono_F').val(value.Telefono_F);
                $('input#Telefono_M').val(value.Telefono_M);
                $('input#Email_N').val(value.Email_N);
                $('input#IniSuscrip').val(value.Fech_Ini_Suscrip);
                $('input#FinSuscrip').val(value.Fech_Fin_Suscrip);
                $('input#Sitio_Web').val(value.Sitio_Web);
                $('input#Facebook').val(value.Facebook);
                $('input#Twitter').val(value.Twitter);
                $('input#Instagram').val(value.Instagram);
                $('input#Otra_Red').val(value.Otra_Red);
                
                //Show/Hide Botones
                $('Button#Guardar').hide();
                $('a#Cancelar').hide();
                $('Button#Editar').show();
                $('Button#Eliminar').show();
                $('a#Cerrar').show();

                //Show  Etiquetas de Datos
                $('b#NombreN').show();
                $('p#Descripcion').show();
                $('p#Direccion').show();
                $('p#Horario').show();
                $('p#TelefonoF').show();
                $('p#TelefonoM').show();
                $('p#Correo').show();
                $('p#IniSuscrip').show();
                $('p#FinSuscrip').show();
                $('p#Sitio').show();
                $('p#Face').show();
                $('p#Tuiter').show();
                $('p#Instagram').show();
                $('p#Otra').show();
                $('p#1').show();
                $('p#2').show();
                $('p#3').show();
                $('p#4').show();
                $('p#5').show();
                $('p#6').show();
                $('p#7').show();
                $('p#8').show();
                $('p#9').show();
                $('p#10').show();  

                //Hide Inputs Editables
                $('div#Nombre_Negocio').addClass("hide");
                $('div#NombreN').addClass("hide");
                $('div#Descripcion').addClass("hide");
                $('div#Direccion_N').addClass("hide");
                $('div#Horario').addClass("hide");
                $('div#Telefono_F').addClass("hide");
                $('div#Telefono_M').addClass("hide");
                $('div#Email_N').addClass("hide");
                $('div#Sitio_Web').addClass("hide");
                $('div#Facebook').addClass("hide");
                $('div#Twitter').addClass("hide");
                $('div#Instagram').addClass("hide");
                $('div#Otra_Red').addClass("hide");
                $('div#Fecha_I').addClass("hide");
                $('div#Fecha_F').addClass("hide");

            });
        });
    }//END Functioon GetNegocio

    function CloseModal(){
        $('#modal1').modal('close');
    }//END Close Modal Detalles

    function DeleteNegocio(){
        $Id = $('input#IdNegocio').val()
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/negocio/delete/' + $Id,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdNegocio: $('input#IdNegocio').val() },
            success: function(value){
                Materialize.toast(value.mensaje, 4000);
                $('#modal1').modal('close');
                /*Recargamos desde caché*/
                location.reload();
                /*Forzamos la recarga*/
                location.reload(true);
                $('Button#Guardar').hide();
                $('a#Cancelar').hide();
                $('Button#Editar').show();
                $('Button#Eliminar').show();
                $('a#Cerrar').show();
            },
            error: function(valie){
                Materialize.toast("Ha ocurrido un error al enviar los datos", 4000);
                $('Button#Guardar').hide();
                $('a#Cancelar').hide();
                $('Button#Editar').show();
                $('Button#Eliminar').show();
                $('a#Cerrar').show();
            }
        });
    }///END DeleteNegocio

    function EditNegocio(){
        //Show/Hide Botones para Editar Elementos
        $('Button#Guardar').show();
        $('a#Cancelar').show();
        $('Button#Editar').hide();
        $('Button#Eliminar').hide();
        $('a#Cerrar').hide();
        

         //Show Etiquetas de Datos
         $('b#NombreN').hide();  
         $('ul#datos-redes-coll').hide(); 
         $('ul#datos-general-coll').hide();
         $('p#fecha_inicio').hide();
         $('p#fecha_fin').hide();
         $('p#Descripcion').hide();
         $('p#Direccion').hide();
         $('p#Horario').hide();
         $('p#TelefonoF').hide();
         $('p#TelefonoM').hide();
         $('p#Correo').hide();
         $('p#Sitio').hide();
         $('p#Face').hide();
         $('p#Tuiter').hide();
         $('p#Instagram').hide();
         $('p#Otra').hide();

         $('p#1').hide();
         $('p#2').hide();
         $('p#3').hide();
         $('p#4').hide();
         $('p#5').hide();
         $('p#6').hide();
         $('p#7').hide();
         $('p#8').hide();
         $('p#9').hide();
         $('p#10').hide();
            

         //Hide Inputs Editables
         $('div#Nombre_Negocio').removeClass("hide");
         $('div#NombreN').removeClass("hide");
         $('div#Descripcion').removeClass("hide");
         $('div#Direccion_N').removeClass("hide");
         $('div#Horario').removeClass("hide");
         $('div#Telefono_F').removeClass("hide");
         $('div#Telefono_M').removeClass("hide");
         $('div#Email_N').removeClass("hide");
         $('div#Sitio_Web').removeClass("hide");
         $('div#Facebook').removeClass("hide");
         $('div#Twitter').removeClass("hide");
         $('div#Instagram').removeClass("hide");
         $('div#Otra_Red').removeClass("hide");
         $('div#Fecha_I').removeClass("hide");
         $('div#Fecha_F').removeClass("hide");
        
        
    }//END Show Hide Botones para editar Campos 

    function SaveNegocio(){
         //Instancia a FormData con el formulario
         $id = $('input#IdNegocio').val();
         var datosupdate = new FormData();
         datosupdate.append("id", $('input#IdNegocio').val());
         datosupdate.append("Nombre_Negocio", $('input#Nombre_Negocio').val());
         datosupdate.append("Descripcion_N", $('textarea#Descripcion_N').val());
         datosupdate.append("Direccion_N", $('input#Direccion_N').val());
         datosupdate.append("Horario", $('input#Horario').val());
         datosupdate.append("Telefono_F", $('input#Telefono_F').val());
         datosupdate.append("Telefono_M", $('input#Telefono_M').val());
         datosupdate.append("Email_N", $('input#Email_N').val());
         datosupdate.append("Sitio_Web", $('input#Sitio_Web').val());
         datosupdate.append("Facebook", $('input#Facebook').val());
         datosupdate.append("Instagram", $('input#Instagram').val());
         datosupdate.append("Twitter", $('input#Twitter').val());
         datosupdate.append("Otra_Red", $('input#Otra_Red').val()); 
         datosupdate.append("Otra_Red", $('input#IniSuscrip').val());
         datosupdate.append("Otra_Red", $('input#FinSuscrip').val());
         //data.append("file1", document.getElementById("file").files[0]);
         //data.append("file2", document.getElementById("file").files[1]);
         //data.append("file3", document.getElementById("file").files[2]);
         /*for (var pair of datosupdate.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
            }*/
     $.ajax({
         url: '/negocio/Update/' + $id ,
         type: 'POST',
         dataType: 'json',
         headers: { 'X-CSRF-TOKEN': token },
         data: datosupdate,
         processData: false,
         contentType: false,
         success: function(data){//mensaje datos guardados
            Materialize.toast(data.mensaje, 4000);
            //Show / Hide Botones 
            $('Button#Guardar').hide();
            $('a#Cancelar').hide();
            $('Button#Editar').show();
            $('Button#Eliminar').show();
            $('a#Cerrar').show();
            CloseModal();
            /*Recargamos desde caché*/
            location.reload();
            /*Forzamos la recarga*/
            location.reload(true);
         },//mensaje error
         error: function(data){
            Materialize.toast('A ocurrido un Error', 4000);
            CloseModal();
         }
     });//Cierre Ajax

    }//END Metodo para actualizar campos de Negocios

    //Busqueda de negocios
    function complete() {
        var token = $('meta[name=csrf-token]').attr('content');
        $negocio =$('input#autocomplete').val();
        if ($negocio == "" || $negocio == " "){
            $('input#autocomplete').focus();
            $('div#listadoNegocios').show();
            $("#lstServ div").remove();
        }else{
            $.get('/negocios/autocompNegocios/'+ $negocio + '/', function(res){
                $('div#listadoNegocios').hide();
                $("#lstServ div").remove();
                $(res).each(function(key, value){
                    $("div#lstServ").append('<div class="col s12 m6 l6" id="listcard"><div class="card horizontal"><div class="card-image col s12 m4 l4"><img src="/images/Menu/negociolista.png"></div><div class="card-stacked"><div class="card-content"><div class="pdd-ttl-cardLN"><span class="titulo">'+ value.Nombre_Negocio +' </span></div></div><div class="card-action"><button class="waves-effect waves-light btn  modal-trigger" value"'+ value.IdNegocio +'" onclick="GetNegocio('+ value.IdNegocio +');" href="#modal1">Detalles <i class="material-icons prefix right">edit</i></button></div></div></div></div>');
                });
            });
        }
    }//Cierre Busqueda de negocios
@endsection