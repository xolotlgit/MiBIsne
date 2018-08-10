@extends('layouts.layoutUser')

@section('content')
<div></br> </br></div>
<div class="container">

  <div class="panel-body">
      <div class="row">
          <div class="col s12 m12 l12">
            <div class="card horizontal ">
                <div class="card-image">
                    <div class="user-account">
                        <img src="/images/Menu/usuario.png"  class="circle responsive-img">
                    </div>
                </div>
                <div class="card-stacked">                       
                  <div class="card-action">
                    <a href="/usuario/perfil">Editar perfil de usuario</a>
                  </div>
                </div>
            </div>
        </div>
  </div> 
<!--Fin del contenedor para editar perfil -->

<!--Modal para servicios-->
  <!-- Modal Structure -->
  <div id="modalServicios" class="modal">
    <div class="modal-content">
      <!--Inicio del card para los servicios de cada negocio-->
        <div class="card">
            <div class="card-content">
                <div class="cont-padd">
                    <p class="card-title"><b id="NombreNegocioS">Nombre del negocio</b></p>
                    <p class="justify">Este es el listado de servicios que ofrece este negocio en particular. Puede agregar más desde la sección de registro.</p>
                   
                </div>
            </div>
            <div class="card-tabs">
                <ul class="tabs tabs-fixed-width">
                    <li class="tab"><a class="active" href="#listServicios">Listado de servicios</a></li>
                    <li class="tab"><a href="#createServicios">Registro de servicios</a></li>
                </ul>
            </div>
            <div class="card-content grey lighten-4">
                <div id="listServicios">
                    <ul id="datosservicios" class="collection">

                    </ul>
                </div>
                <div id="createServicios">
                    <div class="form-group">
                        <div class="input-field col s12">
                            <div class="cont-padd">
                                <p><b id="NombreNegocioS">Nombre del negocio</b></p>
                                <p><b class="hide" id="IdNegocioS"></b></p>
                            </div>
                        </div>
                    </div></br>
                    <div class="cont-padd">
                        <div class="form-group{{ $errors->has('nombreservicio') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m12 l12">
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
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix">short_text</i>
                                <textarea id="descripcionservicio" type="text" maxlength="250" class="materialize-textarea" name="descripcionservicio"  value="{{ old('descripcionservicio') }}" required></textarea>
                                @if ($errors->has('descripcionservicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descripcionservicio') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:13px;">Descripción del servicio</label>
                            </div>
                        </div> 

                        <div class="form-group{{ $errors->has('costoservicio') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix">credit_card</i>
                                <input id="costoservicio" type="number" class="form-control" name="costoservicio" value="{{ old('costoservicio') }}" required >
                                @if ($errors->has('costoservicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('costoservicio') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:13px;">Costo del servicio</label>
                            </div>
                        </div></br>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button class="waves-effect btn" id="btnGuardarS" onclick="SaveServicio();">Guardar servicio</button>
                            <a class="btn btn-secundario" onclick="CloseModalServicios();">Cancelar</a>
                        </div>
                    </div>
                </div><!--Fin Tab 2-->
            </div>
        </div>
        <!--Fin del card servicios-->
    </div>
</div>

<!---->
<!--CONTENEDOR PRINCIPAL-->                
 <div class="row">
    <div class="card">
        <div class="card-content">
        <!--Boton Menu Lateral--><div class="mlateral col s3 m2 l1"><a class="btn-floating btn-large waves-effect waves-light red tooltipped" data-delay="50" data-position="left" data-tooltip="Registrar negocio"  href="/registrar/negocio"><i class="material-icons">plus_one</i></a></div>
        <span class="card-title"><b>TUS NEGOCIOS</b></span></br></br>
            <div class="panel-body">
            <p class="hide" id="corro">{{Auth::user()->email}}</p>
            <p class="hide" id="label">{{Auth::user()->Clave}}</p>
            <!-- aqui comineza los cards -->
                <div class="row">
                    @foreach($negocios as $nego)
                    <div class="col s12 m6 l6">
                        <div class="card horizontal">
                            <div class="card-image col s12 m4 l4">
                                <img src="/images/Menu/negociolista.png">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                   <div class="pdd-ttl-card"> <span class="tituloN">{{$nego->Nombre_Negocio}}</span></div>
                                </div>
                            <div class="card-action">
                                <button class="waves-effect btn" onclick="GetNegocio({{$nego->IdNegocio}});">Detalles</button>
                                <button class="btn btn-secundario waves-effect waves-light red lighten-2" onclick="GetServicios({{$nego->IdNegocio}});">Servicios</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!--aqui termina los cards-->
            </div>   
         </div>
    </div>
</div>
</div>
</div>
<!--FIN DEL CONTENEDOR PRINCIPAL-->

<!--MODAL DE EDITAR DATOS-->
<div id="modal1" class="modal">
   <div class="modal-content">
      <div class="row">
            <div class="card">
                <div class="card-content">
                    <div class="cab-descripcion">
                        <p class="card-title"><b id="NombreN"></b></p>
                        <div id="Nombre_Negocio" class="input-field col s12 m6 l6 hide">
                            <i class="material-icons prefix">business</i>
                            <input id="Nombre_Negocio" type="text" maxlength="50" class="form-control" name="Nombre_Negocio" value="" autofocus />
                            <label for="icon_prefix" style="font-size:12px;">Nombre de negocio</label>
                        </div>
                        <p class="card-title" id="Descripcion" style="font-size:1.2em;">.</p>
                        <div id="Descripcion" class="input-field col s12 m12 l12 ">
                            <i class="material-icons prefix">short_text</i>
                            <textarea id="Descripcion_N" class="materialize-textarea" maxlength="255" autofocus ></textarea placeholder="Ingresa una pequeña descripción sobre el giro de su negocio">
                            <label for="icon_prefix" style="font-size:13px;">Descripción</label>
                        </div>
                    </div>
                </div>
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab"><a class="active" href="#test4">DATOS GENERALES</a></li>
                        <li class="tab"><a href="#test5">REDES SOCIALES</a></li>
                        <li class="tab"><a href="#test6">IMAGENES</a></li>
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
                                <input id="Horario" type="text" maxlength="100" class="form-control active" name="Horario" value="" autofocus >
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
                        </div>
                    </div>
                    <div id="test5">
                        <div class="list-neg">
                            <ul class="collection" id="datos-redes-coll">
                                <li class="collection-item">
                                    <p id="6">Sitio Web:<i class="material-icons left">laptop</i></p><p  id="Sitio"></p>
                                </li>
                                <li class="collection-item">
                                    <p id="7">Facebook:<i class="material-icons left">thumb_up</i></p><a href=""><p id="Face"></p></a>
                                </li>
                                <li class="collection-item">
                                    <p id="8">Twitter:<i class="fa fa-twitter  left small"></i></p><a><p  id="Twitter"></p></a>
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
                                <input id="Facebook" type="text" maxlength="150" class="form-control" name="Facebook" value="" autofocus>
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
                                        <img id="img1" src="">
                                    </div>
                                </div>
                            </div><!--Fin card imagenes-->
                            <!--Inicio del card para imagenes-->
                            <div class="col s12 m4 l4">
                                <div class="card">
                                    <div class="card-image">
                                        <img id="img2" src="">
                                    </div>
                                </div>
                            </div><!--Fin card imagenes-->
                            <!--Inicio del card para imagenes-->
                            <div class="col s12 m4 l4">
                                <div class="card">
                                    <div class="card-image">
                                        <img id="img3" src="">
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
        
        $email = $('p#corro').text();
        $Clave = $('p#label').text();
        //alert($email);
        //alert($Clave);
        firebase.auth().createUserWithEmailAndPassword($email,$Clave).catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log("Error : " + errorMessage);
        });
    
        var currentUser = firebase.auth().currentUser;
            if(currentUser != null){
                alert("Registro Exitoso;")
            }
        
    });//Cierre document.ready

    function GetNegocio($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $.get('/detalles/negocio/'+ $valor , function(res){
            $(res).each(function(key, value){
                $('#modal1').modal('open');
                //Value para Etiquetas p/b
                $('input#IdNegocio').val(value.IdNegocio);
                $('b#IdNegocioS').text(value.IdNegocio);
                $('b#NombreNegocioS').text(value.Nombre_Negocio);
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
                $('p#Face').text(value.Facebook);
                $('p#Twitter').text(value.Twitter);
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

            });
        });
    }//END Functioon GetNegocio

    function CloseModal(){
        $('#modal1').modal('close');
    }//END Close Modal Detalles
    
    $('#modal1').on('hidden.bs.modal', function () {
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
        $('p#Face').text(value.Facebook);
        $('p#Twitter').text(value.Twitter);
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
    });

    
    function CloseModalServicios(){
        $('#modalServicios').modal('close');
        /*Recargamos desde caché*/
        location.reload();
        /*Forzamos la recarga*/
        location.reload(true);
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

    function SaveServicio(){
        $('#btnGuardarS').attr("disabled",true);
        $IdNegocio = $('b#IdNegocioS').text();
         var datosServicio = new FormData();
         datosServicio.append("id", $IdNegocio);
         datosServicio.append("nombre", $('input#nombreservicio').val());
         datosServicio.append("descripcion", $('textarea#descripcionservicio').val());
         datosServicio.append("precio", $('input#costoservicio').val());
        $.ajax({
            url: '/Save/Servicios/',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            data: datosServicio,
            processData: false,
            contentType: false,
            success: function(data){//mensaje datos guardados
                Materialize.toast(data.mensaje, 4000);
                $('input#nombreservicio').val("");
                $('textarea#descripcionservicio').val("");
                $('input#costoservicio').val("");
                $('#costoservicio').val("");
                $('#btnGuardarS').attr("disabled",false);
                GetServicios($IdNegocio);
            },//mensaje error
            error: function(data){
                Materialize.toast('A ocurrido un Error', 4000);
                CloseModal();
            }
        });//Cierre Ajax
    }
    
    function GetServicios($valor){
        GetNegocio2($valor);
        $("#datosservicios li").remove();
        var token = $('meta[name=csrf-token]').attr('content');
        $.get('/Detalles/Servicios/'+ $valor , function(res){
            $(res).each(function(key, value){
                console.log(value);                 
                //Append ul para Agregar Datos al en li
                $("ul#datosservicios").append('<li id="'+value.IdServicio+'" class="collection-item"><p id="NombreS'+value.IdServicio+'"><b>Nombre: </b>'+value.Nombre_Servicio+'</p><p id="DescripcionS'+value.IdServicio+'"><b>Descripcion: </b>'+value.Descripcion_S+'</p><p id="CostoS'+value.IdServicio+'"><b>Costo: </b>'+value.Costo+'</p></li><li>  <div id="ContenedorDatosUpdate'+value.IdServicio+'" class="hide"><div class="cont-padd"><div class="form-group"><label for="icon_prefix" style="font-size:13px;">Nombre del servicio</label><div class="input-field col s12 m12 l12"><i class="material-icons prefix">edit</i><input id="updatenombreS'+value.IdServicio+'" type="text" maxlength="50" class="form-control"  value="" required autofocus ></div></div> <div class="form-group"><label for="icon_prefix" style="font-size:13px;">Descripción del servicio</label><div class="input-field col s12 m12 l12"><i class="material-icons prefix">short_text</i><textarea id="updtatedescripcionservicio'+value.IdServicio+'" type="text" maxlength="250" class="materialize-textarea" required autofocus></textarea></div></div> <div class="form-group"><label for="icon_prefix" style="font-size:13px;">Costo del servicio</label><div class="input-field col s12 m12 l12"><i class="material-icons prefix">credit_card</i><input id="updatecostoservicio'+value.IdServicio+'" type="number" class="form-control" required autofocus></div></div></br></div></div> </br> <div class="form-group pdd-btn-2"><button id="edit'+value.IdServicio+'" class="btn btn-secundario waves-effect waves-light red lighten-2" onclick="EditServicio('+value.IdServicio+');">Editar <i class="material-icons prefix right">edit</i></button> <button id="delete'+value.IdServicio+'" class="waves-effect btn" onclick="DeleteServicio('+value.IdServicio+');">Eliminar <i class="material-icons prefix right">delete</i></button><button id="save'+value.IdServicio+'" class="btn btn-secundario waves-effect waves-light red lighten-2" onclick="UpdateServicio('+value.IdServicio+');">Guardar Cambios</button><button id="cancel'+value.IdServicio+'" class="waves-effect btn" onclick="CancelarRegServicio('+value.IdServicio+');">Cancelar</button></div></li>');
                $('Button#cancel'+value.IdServicio).hide();
                $('Button#save'+value.IdServicio).hide();
                $('Button#delete'+value.IdServicio).show();
                $('button#edit'+value.IdServicio).show();
                //Get Nombre del Negocio Correspondiente
                $.get('/detalles/negocio/'+ $valor , function(res){
                    $(res).each(function(key, datos){
                        $('b#NombreNegocioS').text(datos.Nombre_Negocio);
                        $('b#IdNegocioS').text(datos.IdNegocio);
                    });
                });
            });
            //Open Modal
            $('#modalServicios').modal('open');
        });
    }//END Functioon GetNegocio

    function DeleteServicio($IdDeleteS){
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/Delete/Servicios/' + $IdDeleteS,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdServicio: $IdDeleteS },
            success: function(value){
                Materialize.toast(value.mensaje, 4000);
                $('#modalServicios').modal('close');
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

    function EditServicio($IdEditS){
        var token = $('meta[name=csrf-token]').attr('content');
        $.get('/Detalle/Servicio/'+ $IdEditS , function(res){
            $(res).each(function(key, value){
                $('Button#cancel'+$IdEditS).show();
                $('Button#save'+$IdEditS).show();
                $('Button#delete'+$IdEditS).hide();
                $('button#edit'+$IdEditS).hide();
                $('p#NombreS'+$IdEditS).hide();
                $('p#DescripcionS'+$IdEditS).hide();
                $('p#CostoS'+$IdEditS).hide();
                $('div#ContenedorDatosUpdate'+$IdEditS).removeClass("hide");
                $('input#updatenombreS'+$IdEditS).val(value.Nombre_Servicio);
                $('textarea#updtatedescripcionservicio'+$IdEditS).val(value.Descripcion_S);
                $('input#updatecostoservicio'+$IdEditS).val(value.Costo);
            });
        });
    }

    function CancelarRegServicio($IdCancelS){
        $('Button#cancel'+$IdCancelS).hide();
        $('Button#save'+$IdCancelS).hide();
        $('Button#delete'+$IdCancelS).show();
        $('button#edit'+$IdCancelS).show();
        $('div#ContenedorDatosUpdate'+$IdCancelS).addClass("hide");
        $('p#NombreS'+$IdCancelS).show();
        $('p#DescripcionS'+$IdCancelS).show();
        $('p#CostoS'+$IdCancelS).show();
    }

    function UpdateServicio($IdUpdateS){
         var datosUpdateServicio = new FormData();
         datosUpdateServicio.append("id", $IdUpdateS);
         datosUpdateServicio.append("nombre", $('input#updatenombreS'+$IdUpdateS).val());
         datosUpdateServicio.append("descripcion", $('textarea#updtatedescripcionservicio'+$IdUpdateS).val());
         datosUpdateServicio.append("precio", $('input#updatecostoservicio'+$IdUpdateS).val());
         for (var pair of datosUpdateServicio.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
            }
        
        $.ajax({
            url: '/Update/Servicios/',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            data: datosUpdateServicio,
            processData: false,
            contentType: false,
            success: function(data){//mensaje datos guardados
                Materialize.toast(data.mensaje, 4000);
                GetServicios($IdUpdateS);
                $('Button#cancel'+$IdUpdateS).hide();
                $('Button#save'+$IdUpdateS).hide();
                $('Button#delete'+$IdCaIdUpdateSncelS).show();
                $('button#edit'+$IdUpdateS).show();
                $('div#ContenedorDatosUpdate'+$IdUpdateS).addClass("hide");
                $('p#NombreS'+$IdUpdateS).show();
                $('p#DescripcionS'+$IdUpdateS).show();
                $('p#CostoS'+$IdUpdateS).show();
            },//mensaje error
            error: function(data){
                Materialize.toast('A ocurrido un Error', 4000);
                CloseModal();
            }
        });//Cierre Ajax
    }

    function GetNegocio2($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $.get('/detalles/negocio/'+ $valor , function(res){
            $(res).each(function(key, value){
                //Value para Etiquetas p/b
                $('input#IdNegocio').val(value.IdNegocio);
                $('b#IdNegocioS').text(value.IdNegocio);
                $('b#NombreNegocioS').text(value.Nombre_Negocio);
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
                $('p#Face').text(value.Facebook);
                $('p#Twitter').text(value.Twitter);
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
    
            });
        });
    }//END Functioon GetNegocio

    
@endsection