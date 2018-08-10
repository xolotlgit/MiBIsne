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
    <div class="col s12 m8 l6 offset-m3 offset-l3 ">
      <div class="card">
        <div class="card-content">
           <div class="cont-padd">
              </br><span class="card-title"><b>REGISTRAR CATEGORÍA</b></span>  </br>
                <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="{{url('categorias')}}" onsubmit="return validarFormulario()">
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('nombrecategoria') ? ' has-error' : '' }}">
                            <div class="input-field ">
                            <i class="material-icons prefix">edit</i>
                                <input id="nombrecategoria" type="text" maxlength="150" class="form-control" name="nombrecategoria" value="{{ old('nombrecategoria') }}" required autofocus >
                                @if ($errors->has('nombrecategoria'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nombrecategoria') }}</strong>
                                    </span>
                                @endif
                                 <label for="icon_prefix" style="font-size:13px;">Nombre de la categoría</label>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('descripcioncategoria') ? ' has-error' : '' }}">
                            <div class="input-field ">
                            <i class="material-icons prefix">short_text</i>
                                <textarea id="descripcioncategoria" type="text" maxlength="300" class="materialize-textarea" name="descripcioncategoria"  value="{{ old('descripcioncategoria') }}" max="280" required autofocus></textarea>
                                @if ($errors->has('descripcioncategoria'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descripcioncategoria') }}</strong>
                                    </span>
                                @endif
                                <label for="icon_prefix" style="font-size:13px;">Descripción de la categoría</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn" id="btsubmit">
                                    Guardar
                                </button>

                                <a class=" btn" href="/categorias" style="background-color:#E57373;">
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

<script>
    function validarFormulario(){
        var txtNombreCategoria = document.getElementById('nombrecategoria').value;
        var txtDescripcion = document.getElementById('descripcioncategoria').value;

        //Test campo obligatorio
        if(txtNombreCategoria == null || txtNombreCategoria.length == 0 || /^\s+$/.test(txtNombreCategoria)){
            Materialize.toast('Atención: El nombre de la categoría no puede ir vacío o lleno solo por espacios en blanco.', 8000);
            return false;
        }

        //Test campo obligatorio
        if(txtDescripcion == null || txtDescripcion.length == 0 || /^\s+$/.test(txtDescripcion)){
            Materialize.toast('Atención: La descripción de la categoría no puede ir vacía o llena solo por espacios en blanco.', 8000);
            return false;
        }

        //Deshabilitar el boton una vez que se oprima guardar
        document.getElementById("btsubmit").value = "Guardando...";
        document.getElementById("btsubmit").disabled = true;
        return true;
    }
</script>


@endsection






