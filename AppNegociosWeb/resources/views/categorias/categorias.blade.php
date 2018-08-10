@extends('layouts.app')

@section('content')
<!--Modal de editar datos-->
<div id="modal1" class="modal">
 <div class="modal-content">
  <h5>Información de categorías</h5></br>
  <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
    <div class="form-group{{ $errors->has('nombrecategoria') ? ' has-error' : '' }}">
       <div class="input-field ">
          <i class="material-icons prefix">edit</i>
          <input id="nombrecategoria" type="text" maxlength="150" class="form-control" name="nombrecategoria" required autofocus >
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
          <textarea id="descripcioncategoria" type="text" maxlength="300" class="materialize-textarea" name="descripcioncategoria"  required autofocus></textarea>
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
          <a class="waves-effect waves-light btn modal-trigger" onclick="SetDatosAct();" href="#modal1">Guardar</a>
          <a class=" btn" href="/categorias" style="background-color:#E57373;">Cancelar</a>
       </div>
    </div>

  </div>
</div>
<!--Fin del modal-->

<!-- Modal Delete -->
<div id="modalDelete" class="modal">
    <div class="modal-content">
        <h5>¿Esta seguro que desea eliminar este registro?</h5>
        <p class="justify">Tenga en cuenta que al eliminar esta categoría se borrarán todos los negocios relacionados con esta. Esta seguro que desea continuar?</p>
        <input id="idget" type="hidden" class="form-control hide" name="idget" value="0" >
    </div>
    <div class="modal-footer">
        <button class="waves-effect btn" id="Eliminar" onclick="DeleteCategoria();" style="background-color:#E57373;">Eliminar<i class="material-icons prefix right">delete</i></button>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="CloseModal();">Cancelar</a>
    </div>
</div>      

<!--Contenedor prncipal-->
<div></br> </br></div>
 <div class="container">
 @if(session()->has('msg'))
  <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
 @endif
 @if(session()->has('msgerror'))
  <div class="alert alert-warning" role="alert">{{ session('msgerror')}}</div>
 @endif
    <div class="row">
        <div class="card">
           <div class="card-content">
             <span class="card-title"><b>CATEGORÍAS</b></span> 
               </br> 
                  <div class="panel-body">
                     <div class="row">
                     <!--Cards-->
                          @foreach($categorias as $cate)
                             <div class="col s12 m6 l6">
                               <div class="card">
                                    <div style="height:115px; overflow-y: scroll;">
                                        <div class="card-content">
                                            <p class="t-categorias">{{$cate->NombreCategoria}}</p>
                                            <p class="d-categorias">{{$cate->Descripcion}}</p>
                                            <input id="id" type="number" class="form-control hide" name="id" value="{{$cate->IdCategoria}}">
                                        </div>
                                    </div>
                                    <div class="card-action">
                                        <button class="waves-effect waves-light btn modal-trigger" value"{{$cate->IdCategoria}}" onclick="GetDatos({{$cate->IdCategoria}});" href="#modal1" style="background-color:#E57373;"><i class="material-icons prefix right">create</i>  Editar</button>
                                        <button class="waves-effect waves-light red darken-2 btn modal-trigger" value"{{$cate->IdCategoria}}" onclick="GetIdD({{$cate->IdCategoria}});" id="Eliminar" href="#modalDelete">Eliminar<i class="material-icons prefix right">delete</i></button>
                                    </div>
                                 </div> 
                            </div>  
                         @endforeach
                         <!--Cards-->   
                   </div> 
                   <!-- Paginación -->
                    <center><b>{{ $categorias->links() }}</b></center>
                </div>
             </div>
          </div>
      </div>
 </div>
@endsection
  

@section('metodosJava')
    $(document).ready(function(){
        $('.modal').modal();
        Materialize.toast(value.mensaje, 4000);
    });

    function GetDatos($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/categorias/'+ $valor + '/edit', function(res){
            $('input#idget').val($valor);
            $('input#nombrecategoria').val(res.NombreCategoria);
            $('textarea#descripcioncategoria').val(res.Descripcion);
        });
    }
    function SetDatosAct(){
        $btn = $('input#idget').val();
        
        $.ajax({
            url: '/categorias/' + $btn,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { NombreCategoria: $('input#nombrecategoria').val(), Descripcion: $('textarea#descripcioncategoria').val()},
            success: function(value){
                $('#modal1').modal('close');
                Materialize.toast(value.mensaje, 4000);
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

    function CloseModal(){
        $('#modalDelete').modal('close');
    }//END Close Modal Detalles

    function GetIdD($valor){
        var token = $('meta[name=csrf-token]').attr('content');
        $btn = $('input#id').val();
        $.get('/categorias/'+ $valor + '/delete', function(res){
            $('input#idget').val($valor);
        });
    }

    function DeleteCategoria(){
        $Id = $('input#idget').val()
        //alert($Id);
        var token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: '/categorias/delete/' + $Id,
            type: 'PUT',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content') },
            data: { IdServicio: $('input#idget').val() },
            success: function(value){
                $('#modal1').modal('close');
                Materialize.toast(value.mensaje, 4000);
                /*Recargamos desde caché*/
                location.reload();
                /*Forzamos la recarga*/
                location.reload(true);
            },
            error: function(valie){
                Materialize.toast("Ha ocurrido un error al enviar los datos", 4000);
            }
        });
    }///END DeleteCategoria

 @endsection

