@extends('layouts.app')

@section('content')
<div></br> </br></div>
<div class="container">
 @if(session()->has('msg'))
     <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
 @endif
 @if(session()->has('msgerror'))
    <div class="alert alert-warning" role="alert">{{ session('msgerror')}}</div>
 @endif
  <div class="row">
    <div class="col s12 m8  l6 offset-m2 offset-l3 ">
      <div class="card">
        <div class="card-content">
           <div class="cont-padd">
              <span class="card-title"><b>REGISTRAR CONTACTOS</b></span>
              </br> 
                <div class="panel-body">
                   <form class="form-horizontal" role="form" method="POST" action="{{url('contactos')}}" onsubmit="return validarFormulario()">
                    {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix left">person</i>
                                <input id="nombre" type="text" maxlength="50" class="form-control" name="nombre" value="{{ old('nombre') }}" required autofocus >
                                @if ($errors->has('nombre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix">Nombre</label>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix left">mail</i>
                                <input id="email" type="email" maxlength="60" class="form-control" name="email" value="{{ old('email') }}" required autofocus >
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix">Email</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono1') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix left">phone</i>
                                <input id="telefono1" type="tel" class="form-control" name="telefono1" value="{{ old('telefono1') }}" required autofocus >
                                @if ($errors->has('telefono1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefono1') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix">Teléfono</label>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefono2') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m12 l12">
                                <i class="material-icons prefix left">phone_android</i>
                                <input id="telefono2" type="tel" class="form-control" name="telefono2" value="{{ old('telefono2') }}" autofocus >
                                @if ($errors->has('telefono2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefono2') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix">Teléfono alternativo</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn waves-effect waves-red" id="btsubmit">
                                    Guardar
                                </button>
                                <a class=" btn" href="/contactos" style="background-color:#E57373;">
                                   Cancelar
                                </a>
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
<!--Script para validacion de formulario-->
<script>
    function validarFormulario(){
        var txtNombreContacto = document.getElementById('nombre').value;
        var txtTelefono = document.getElementById('telefono1').value;
        var txtTelefono2 = document.getElementById('telefono2').value;
        
        //Test Nombre campo obligatorio
        if(txtNombreContacto == null || txtNombreContacto.length == 0 || /^\s+$/.test(txtNombreContacto)){
            Materialize.toast('Atención: El nombre del contacto no puede ir vacío o lleno solo por espacios en blanco.', 8000);
            return false;
        }

        //Telefono campo obligatorio
        if( !(/^\d{10}$/.test(txtTelefono)) ) {
           Materialize.toast('Atención: Introduzca un numero de teléfono valido, Ejempo: 7717894710', 8000);
           return false;
        }

        //Validar Telefono alternativo
       /* if( !(/^\d{10}$/.test(txtTelefono2)) ) {
           Materialize.toast('Atención: Introduzca un numero de teléfono valido, Ejempo: 7717894710', 8000);
           return false;
        }*/  

        //Deshabilitar el boton una vez que se oprima guardar
        document.getElementById("btsubmit").value = "Guardando...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }
</script>


@endsection
