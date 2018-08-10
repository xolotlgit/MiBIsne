@extends('layouts.app')
@section('content')
<!--Contenedor Principal-->
<div></br> </br></div>
 <div class="container">
    @if(session()->has('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
    @endif
    @if(session()->has('msgerror'))
    <div class="alert alert-warning" role="alert">{{ session('msgerror')}}</div>
    @endif
   <div class="row">
        <div class="col s12 m6  l6 offset-m3 offset-l3 offset-s">
          <div class="card">
            <div class="card-content"></br>
             <span class="card-title"><b>REGISTRO DE SERVICIOS</b></span></br>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{url('servicios')}}" onsubmit="return validarFormulario()">
                        {{ csrf_field() }}

                      <div class="form-group">
                       <label class="col s12 m12 l12"  style="font-size:14px;">Negocio</label>
                        <div class="input-field col s12">
                             <div>
                                <select id="IdNegocio" name="IdNegocio"  class="browser-default">
                                    <option value="" disabled selected style="font-size:14px;" autofocus>Selecciona un negocio</option>
                                     @foreach($negocio as $nego)
                                      <option value="{{$nego->IdNegocio}}">{{$nego->Nombre_Negocio}}</option>
                                    @endforeach
                                </select>
                             </div>
                           </div>
                         </div></br></br></br></br></br>

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
                                <textarea id="descripcionservicio" type="text" maxlength="250"  class="materialize-textarea" name="descripcionservicio"  value="{{ old('descripcionservicio') }}" required autofocus></textarea>
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
                                <button type="submit" class="btn btn-succes" id="btsubmit">
                                    Guardar
                                </button>

                                <a class="btn" href="/servicios" style="background-color:#E57373;">
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

<script>
    function validarFormulario(){
        var txtNombreServicio = document.getElementById('nombreservicio').value;
        var txtDescripcion = document.getElementById('descripcionservicio').value;
        var txtCosto = document.getElementById('costoservicio').value;
        var cmbNegocio = document.getElementById('IdNegocio').selectedIndex;

       
        //Test campo obligatorio
        if(txtNombreServicio == null || txtNombreServicio.length == 0 || /^\s+$/.test(txtNombreServicio)){
            Materialize.toast('Atención: El nombre del servicio no puede ir vacío o lleno solo por espacios en blanco.', 8000);
            return false;
        }

        //Test campo obligatorio
        if(txtDescripcion == null || txtDescripcion.length == 0 || /^\s+$/.test(txtDescripcion)){
            Materialize.toast('Atención: La descripción del negocio no puede ir vacía o llena solo por espacios en blanco.', 8000);
            return false;
        }

        //Test comboBox Negocios
		if(cmbNegocio == null || cmbNegocio == 0){
			Materialize.toast('Atencion: Debe seleccionar el negocio al que le pertenece el servicio.', 8000);
			return false;
		}

        //Test Costo
		if(isNaN(txtCosto)){
			Materialize.toast('Atención: Debe ingresar una costo para su servicio.', 8000);
			return false;
		}

         //Deshabilitar el boton una vez que se oprima guardar
        document.getElementById("btsubmit").value = "Guardando...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }
</script>


@endsection


