@extends('layouts.app')
@section('content')
<div></br> </br></div>
<div class="container">
   <div class="row">
       <div class="col s12 m12  l11 offset-l1">
           <div class="card card">
               <div class="card-content hoverable">
                  </br><span class="card-title col s12 m12 l12 "><b>REGISTRAR NEGOCIO</b></span>
                    <div class="panel-body">
                        <form class="form-horizontal" files="true" id="fromNegocios" enctype="multipart/form-data" role="form" method="POST" action="{{url('createneg')}}">
                            {{ csrf_field() }}
                            <div class="row">
                              <div class="cont-padd">
                                <div class="col s12">
                                   <div class="row">
                                     <table id="buscausuarios" class="bordered highlight">
                                        <thead>
                                          <div class="input-field col s12 m12 l12">
                                             <i class="material-icons prefix">search</i>
                                             <input type="text" id="autocomplete" onkeyup="complete();" class="autocomplete" autofocus>
                                             <label for="autocomplete-input">Nombre o Correo de Usuario</label>
                                          </div>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                     </table> 
                                   </div>

                                   <div class="row hide" id="userid">
                                      <table id="userselec" class="bordered highlight">
                                          <tbody>
                                             <div class="input-field col s12 m12 l12">
                                                <i class="material-icons prefix">person</i>
                                                <input disabled  type="text" id="id" name="id" class="form-control hide">
                                                <input disabled  type="text" id="Nombre_User" name="Nombre_User" class="form-control">
                                              </div>
                                           </tbody>
                                       </table> 
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="form-group{{ $errors->has('Nombre_Negocio') ? ' has-error' : '' }}">
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">business</i>
                                            <input id="Nombre_Negocio" type="text" maxlength="30" class="form-control" name="Nombre_Negocio" value="{{ old('Nombre_Negocio') }}" required />
                                             @if ($errors->has('Nombre_Negocio'))
                                               <span class="help-block">
                                                  <strong>{{ $errors->first('Nombre_Negocio') }}</strong>
                                               </span>
                                                @endif
                                            <label for="icon_prefix" style="font-size:12px;">Nombre de negocio</label>
                                         </div>
                                      </div>
                                      <div class="input-field col s12 m6 l6">
                                         <select id="IdCategoria">
                                           <option value="0" style="font-size:14px;" selected disabled>Seleccione una Categoría</option>
                                           @foreach($categoria as $cate)
                                             <option value="{{$cate->IdCategoria}}">{{$cate->NombreCategoria}}</option>
                                           @endforeach
                                         </select>
                                     </div>
                                  </div>
                                  <div class="row">
                                     <div class="form-group{{ $errors->has('Descripcion') ? ' has-error' : '' }}">
                                         <div class="input-field col s12 m12 l12 ">
                                            <i class="material-icons prefix">short_text</i>
                                            <textarea id="Descripcion" class="materialize-textarea"  maxlength="255" required ></textarea placeholder="Ingresa una pequeña descripción sobre el giro de su negocio">
                                              @if ($errors->has('Descripcion'))
                                              <span class="help-block">
                                                 <strong>{{ $errors->first('Descripcion') }}</strong>
                                              </span>
                                              @endif
                                             <label for="icon_prefix" style="font-size:13px;">Descripción</label>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="row">
                                     <div class="form-group{{ $errors->has('Direccion_N') ? ' has-error' : '' }}">
                                         <div class="input-field col s12 m6 l6">
                                             <i class="material-icons prefix">edit</i>
                                             <input id="Direccion_N" type="text" maxlength="80" class="form-control" name="Direccion_N" value="{{ old('Direccion_N') }}" required >
                                              @if ($errors->has('Direccion_N'))
                                               <span class="help-block">
                                                 <strong>{{ $errors->first('Direccion_N') }}</strong>
                                               </span>
                                              @endif
                                              <label for="icon_prefix" style="font-size:12px;">Dirección</label>
                                          </div>
                                      </div>
                                      <div class="form-group{{ $errors->has('Horario') ? ' has-error' : '' }}">
                                         <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">timer</i>
                                            <input id="Horario" type="text" maxlength="100" class="form-control" name="Horario" value="{{ old('Horario') }}" required >
                                             @if ($errors->has('Horario'))
                                               <span class="help-block">
                                                 <strong>{{ $errors->first('Horario') }}</strong>
                                               </span>
                                             @endif
                                             <label for="icon_prefix" style="font-size:12px;">Horario</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group{{ $errors->has('Telefono_F') ? ' has-error' : '' }}">
                                          <div class="input-field col s12 m6 l6">
                                             <i class="material-icons prefix">phone</i>
                                             <input id="Telefono_F" type="text" maxlength="10" class="form-control" name="Telefono_F" value="{{ old('Telefono_F') }}" required >
                                             @if ($errors->has('Telefono_F'))
                                             <span class="help-block">
                                               <strong>{{ $errors->first('Telefono_F') }}</strong>
                                             </span>
                                             @endif
                                             <label for="icon_prefix" style="font-size:12px;">Teléfono fijo</label>
                                          </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('Telefono_M') ? ' has-error' : '' }}">
                                           <div class="input-field col s12 m6 l6">
                                              <i class="material-icons prefix">phone_android</i>
                                              <input id="Telefono_M" type="text" maxlength="10" class="form-control" name="Telefono_M" value="{{ old('Telefono_M') }}" required>
                                               @if ($errors->has('Telefono_M'))
                                                <span class="help-block">
                                                  <strong>{{ $errors->first('Telefono_M') }}</strong>
                                                </span>
                                               @endif
                                               <label for="icon_prefix" style="font-size:12px;">Teléfono alternativo</label>
                                           </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group{{ $errors->has('Email_N') ? ' has-error' : '' }}">
                                          <div class="input-field col s12 m6 l6">
                                             <i class="material-icons prefix">email</i>
                                             <input id="Email_N" type="email" maxlength="60" class="form-control" name="Email_N" value="{{ old('Email_N') }}" required>
                                              @if ($errors->has('Email_N'))
                                               <span class="help-block">
                                                 <strong>{{ $errors->first('Email_N') }}</strong>
                                               </span>
                                             @endif
                                             <label for="icon_prefix" style="font-size:12px;">Email</label>
                                          </div>
                                        </div>
                                        <div class="input-field col s12 m6 l6">
                                            <i class="material-icons prefix">laptop</i>
                                            <input id="Sitio_Web" type="url" maxlength="150" class="form-control" name="Sitio_Web" value="{{ old('Sitio_Web') }}">
                                             @if ($errors->has('Sitio_Web'))
                                             <span class="help-block">
                                               <strong>{{ $errors->first('Sitio_Web') }}</strong>
                                             </span>
                                            @endif
                                            <label for="icon_prefix" style="font-size:12px;">Sitio web</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group{{ $errors->has('Facebook') ? ' has-error' : '' }}">
                                          <div class="input-field col s12 m6 l6">
                                             <i class="material-icons prefix">thumb_up</i>
                                             <input id="Facebook" type="text" maxlength="150" class="form-control" name="Facebook" value="{{ old('Facebook') }}">
                                              @if ($errors->has('Facebook'))
                                              <span class="help-block">
                                                <strong>{{ $errors->first('Facebook') }}</strong>
                                              </span>
                                              @endif
                                              <label for="icon_prefix" style="font-size:12px;">Facebook</label>
                                           </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('Instagram') ? ' has-error' : '' }}">
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">favorite</i>
                                                <input id="Instagram" type="text" maxlength="150" class="form-control" name="Instagram" value="{{ old('Instagram') }}">
                                                 @if ($errors->has('Instagram'))
                                                 <span class="help-block">
                                                   <strong>{{ $errors->first('Instagram') }}</strong>
                                                 </span>
                                                 @endif
                                                <label for="icon_prefix" style="font-size:12px;">Instagram</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group{{ $errors->has('Twitter') ? ' has-error' : '' }}">
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">face</i>
                                                <input id="Twitter" type="text" maxlength="100" class="form-control" name="Twitter" value="{{ old('Twitter') }}">
                                                  @if ($errors->has('Twitter'))
                                                    <span class="help-block">
                                                       <strong>{{ $errors->first('Twitter') }}</strong>
                                                    </span>
                                                 @endif
                                                <label for="icon_prefix" style="font-size:12px;">Twitter</label>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('Otra_Red') ? ' has-error' : '' }}">
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">create</i>
                                                <input id="Otra_Red" type="text" maxlength="100" class="form-control" name="Otra_Red" value="{{ old('Otra_Red') }}">
                                                @if ($errors->has('Otra_Red'))
                                                 <span class="help-block">
                                                   <strong>{{ $errors->first('Otra_Red') }}</strong>
                                                 </span>
                                                @endif
                                                <label for="icon_prefix" style="font-size:12px;">Otra red social</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">event</i>
                                                <input type="text" class="datepicker" id="Fech_Ini_Suscrip" name="Fech_Ini_Suscrip" value="{{$mesInicio}}">
                                                <label for="icon_prefix" style="font-size:12px;">Fecha de inicio de suscripción</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-field col s12 m6 l6">
                                                <i class="material-icons prefix">event</i>
                                                <input type="text" class="datepicker" id="Fech_Fin_Suscrip" name="Fech_Fin_Suscrip" value="{{$mesFin}}">
                                                <label for="icon_prefix" style="font-size:12px;">Fecha de termino de la suscripción</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="file-field input-field col s12 m12 l12">
                                          <div class="btn">
                                             <span>Buscar imagenes</span>
                                             <input type="file" id="file" name="file[]" multiple>
                                          </div>
                                          <div class="file-path-wrapper col s12 m12 l12">
                                            <input class="file-path validate" type="text" >
                                          </div>  
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="form-group">
                                         <div class="input-field col s12  m12 l12">  
                                            <i class="material-icons prefix">border_color</i>
                                            <div class="chips chips-placeholder" id="Tags" data-index="0" data-initialized="true"></div>
                                            <label>Palabras clave para relacionar con su negocio. Enter para agregar la palabra clave.</label>
                                         </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <a class="btn tooltipped" data-position="bottom" data-delay="50" data-tooltip="Guarda tu Negocio!!" id="guardarN" type="submit">Guardar Negocio</a>
                                       <a class="btn btn-secundario waves-effect waves-light red lighten-2"  href="/home" data-position="bottom" data-delay="50" data-tooltip="Regresar al menú principal">Cancelar</a>
                                    </div>
                                </div>
                              </div>
                           </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--
<script> 
        //Deshabilitar el boton una vez que se oprima guardar
       // document.getElementById("guardarN").value = "Guardando...";
       // document.getElementById("guardarN").disabled = true;
        //return true;
</script>-->                  
@endsection

@section('metodosJava')
var token = $('meta[name=csrf-token]').attr('content');
    $(document).ready(function(){
        //indicializa token de seguridad
        var token = $('meta[name=csrf-token]').attr('content');

        //Indicializa Combox Selec Categorias
        $('select').material_select();
        
        //indicializa auntocomplete
        $('input.autocomplete').autocomplete({
            data: {
              
            },
            limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
            onAutocomplete: function(val) {
              // Callback function when value is autcompleted.
            },
            minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
        });//Cierre indicializacion auntocomplete

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

        //indicializa Chips para Tags
        $('.chips-placeholder').material_chip({
            placeholder: '',
            secondaryPlaceholder: '+ Etiqueta',
        });//Cierre indicializacion Chips

        //Accion del Boton Guardar
        var token = $('meta[name=csrf-token]').attr('content');//token laravel
        $('#guardarN').click(function(){
         
        var cmbIdCategoria = document.getElementById('IdCategoria').selectedIndex;
        var txtDescripcion= document.getElementById('Descripcion').value;
        var txtDireccion_N= document.getElementById('Direccion_N').value;
        var txtHorario= document.getElementById('Horario').value;
        var txtTelefono_F= document.getElementById('Telefono_F').value;
        var txtFechaInicio= document.getElementById('Fech_Ini_Suscrip').value;
        var txtFechaFin= document.getElementById('Fech_Fin_Suscrip').value;
        var txtFile= document.getElementById('file').value;  
        var txtEmail= document.getElementById('Email_N').value;  
          
           if( $('input#id').val().trim() == ""){
                 $('input#id').focus();
                 Materialize.toast("Necesitas elejir el usuario al que le pertenece el negocio", 8000);
            }
            if( $('input#Nombre_Negocio').val().trim() == ""){
                 $('input#Nombre_Negocio').focus();
                 Materialize.toast("Asigna un nombre a tu negocio", 8000);
            }
             //comboBox Categoria campo obligatorio
            if(cmbIdCategoria == null || cmbIdCategoria == 0){
                IdCategoria.focus();
                Materialize.toast("Debe seleccionar la categoria a la que pertenece tu negocio", 8000);
                return false;
            }

            //Descripcion campo obligatorio
            if(txtDescripcion == null || txtDescripcion.length == 0 || /^\s+$/.test(txtDescripcion)){
                Materialize.toast("La descripcion del negocio no puede ir vacía", 8000);
                return false;
            }

            //Direccion campo obligatorio
            if(txtDireccion_N == null || txtDireccion_N.length == 0 || /^\s+$/.test(txtDireccion_N)){
                Materialize.toast("El campo direccion no puede ir vacío", 8000);
                return false;
            }

            //Horario campo obligatorio
            if(txtHorario == null || txtHorario.length == 0 || /^\s+$/.test(txtHorario)){
                Materialize.toast("El Horario no puede ir vacío", 8000);
                return false;
            }        

            //Telefono campo obligatorio
            if( !(/^\d{10}$/.test(txtTelefono_F)) ) {
                Materialize.toast("Introduzca un numero de teléfono valido, Ejempo: 7717894710", 8000);
                return false;
            }

            //Validar Imagnes, campo obligatorio
            if(txtEmail == null || txtEmail.length == 0 || /^\s+$/.test(txtEmail)){
                Materialize.toast("Ingrese un correo electrónico para su negocio.", 8000);
                return false;
            }

            //Validacion, fechas de la suscripcion, Campos obligatorios
            if(txtFechaInicio == null || txtFechaInicio.length == 0 || /^\s+$/.test(txtFechaInicio)){
                Materialize.toast("La fecha de inicio de suscripcion no puede ir  vacia", 8000);
                return false;
            }

            if(txtFechaFin == null || txtFechaFin.length == 0 || /^\s+$/.test(txtFechaFin)){
                Materialize.toast("La fecha de fin de suscripcion no puede ir  vacia", 8000);
                return false;
            }

            //Validar Imagnes, campo obligatorio
            if(txtFile == null || txtFile.length == 0 || /^\s+$/.test(txtFile)){
                Materialize.toast("Debes seleccionar las imagenes que identificaran a tu negocio.", 8000);
                return false;
            }
            
            //Get Tags Escritas
            var Tags = ""; 
            let chipsObjectValue = $('#Tags').material_chip('data');
            $.each(chipsObjectValue, function(key, value) {
                Tags += value.tag + "_";                 
            });
            //Instancia a FormData con el formulario
            var data = new FormData();
                data.append("id", $('input#id').val());
                data.append("Nombre_Negocio", $('input#Nombre_Negocio').val());
                data.append("Descripcion", $('textarea#Descripcion').val());
                data.append("Direccion_N", $('input#Direccion_N').val());
                data.append("Horario", $('input#Horario').val());
                data.append("Telefono_F", $('input#Telefono_F').val());
                data.append("Telefono_M", $('input#Telefono_M').val());
                data.append("Email_N", $('input#Email_N').val());
                data.append("IdCategoria", $('#IdCategoria').val());
                data.append("Sitio_Web", $('input#Sitio_Web').val());
                data.append("Facebook", $('input#Facebook').val());
                data.append("Instagram", $('input#Instagram').val());
                data.append("Twitter", $('input#Twitter').val());
                data.append("Otra_Red", $('input#Otra_Red').val());
                data.append("Fech_Ini_Suscrip", $('input#Fech_Ini_Suscrip').val());
                data.append("Fech_Fin_Suscrip", $('input#Fech_Fin_Suscrip').val());
                data.append("Tags" , Tags);
                if(document.getElementById("file").files[1] == null || document.getElementById("file").files[2] == null){
                    if(document.getElementById("file").files[1] == null){
                        data.append("file2", "null");
                    }else{
                        data.append("file2", document.getElementById("file").files[1]);
                        Materialize.toast("solo tienes 2 imagenes para tu negocio.", 8000);
                    }
                    if(document.getElementById("file").files[2] == null){
                        data.append("file3", "null");
                    }else{
                        data.append("file3", document.getElementById("file").files[2]);
                    }
                }
            if(document.getElementById("file").files[0] == null){
                Materialize.toast("Debes seleccionar las al menos una imagen.", 8000);
            }
            else{
                data.append("file1", document.getElementById("file").files[0]);
                $.ajax({
                    url: '/registronegocios',
                    type: 'POST',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': token },
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data){//mensaje datos guardados
                        Materialize.toast(data.mensaje, 4000);
                        document.getElementById("fromNegocios").reset();
                    },//mensaje error
                    error: function(data){
                    Materialize.toast('A ocurrido un Error', 4000);
                    
                    }
                });//Cierre guardarN
            }
        });//Cierre clic Botton Guardar

    });//Cierre document.ready

    //Busqueda de usuarios
    function complete() {
        var token = $('meta[name=csrf-token]').attr('content');
        var usuario = document.getElementById("autocomplete").value;
        if (usuario == "" || usuario == " "){
            $('input#autocomplete').focus();
        }else{
            $.get('/negocios/autousuarios/'+ usuario + '/', function(res){
                $("#buscausuarios tbody tr").remove();
                $(res).each(function(key, value){
                    $('#buscausuarios tbody').append('<tr><td><a class="btn-body col s12 m12 l12" onclick="userselec('+ value.id +');"><span class="left"><b>Nombre: </b> '+ value.Nombre_User + ' '+  value.Apellidos + ' </span><span class="right"><b>Email: </b> ' + value.email +'</span></a></td></tr>');
                });
            });
        }
    }//Cierre Busqueda de usuarios

    function userselec(id){
        
        var token = $('meta[name=csrf-token]').attr('content');
        $.get('/negocios/getuser/'+ id + '/', function(res){
            $(res).each(function(key, value){
                $("#buscausuarios tbody tr").remove();
                $('div#userid').removeClass( "hide" );
                $('input#id').val(id);        
                $('input#Nombre_User').val(value.Nombre_User + " " + value.Apellidos);
            });
        });
    }//Cierre userselec
@endsection