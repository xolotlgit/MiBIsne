@extends('layouts.app')

@section('content')
</br>
<div class="container">
  <div class="row">
    <div class="col s12 m10 l8 offset-l2 offset-m1">
       <div class="card horizontal">
          <div class="card-image col s4 l4">
             <div class="img-login">
               <div style="max-width:160px; max-height:160px; padding-left:20px;">
                  <img src="/images/Menu/isotipo-2.png" class="img-responsive">
               </div>
             </div>
          </div>
          <div class="card-stacked ">
             <div class="card-content ">
               <div class="panel-body">
                  <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="row">
                     
                     <!--Inicio del los componentes del Form-->
                       <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                         <div class="input-field col s10 l10">
                            <i class="material-icons prefix left small">account_circle</i>
                              <input id="login" type="login" class="form-control" style="font-size:13px;" name="login" value="{{ old('login') }}" required autofocus placeholder="Nombre de usuario/correo electrónico">
                               @if ($errors->has('login'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('login') }}</strong>
                                </span>
                               @endif
                             
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-field col s10 l10">
                               <i class="material-icons prefix left">lock</i>
                                <input id="password" type="password" class="form-control" style="font-size:13px;" name="password" required placeholder="Contraseña">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                               
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div >
                           <div class="checkbox">
                              <input type="checkbox" id="test6" checked="checked" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                              <label for="test6" style="font-size:12px;">Recordar contraseña</label>
                           </div>
                        </div>
                    </div></br>
                    <div class="form-group">
                       <div class="col-md-8">
                          <button type="submit" class="btn btn-primary waves-effect waves-light red darken-2 col s4 l4">
                             Ingresar
                          </button>
                         <p class="col s6 l6 m6"><a class="btn-link fnt-login" href="{{ route('password.request') }}">Olvidaste tu contraseña?</a></p></center>
                      </div></br></br>
                    </div>     
                </div>
              </form>
            </div> 

         </div>
       </div>
       
       <div class="card">
         <div class="card-content">
            <center>
                <a class="waves-effect btn indigo darken-2  style-font-fb" href="{{ url('login/facebook') }}"><i class="fa fa-facebook left small"></i>Ingresar con Faceboook</a>
                <a class=" waves-effect waves-light red darken-2 btn btn-link style-font-g" href="{{ url('login/google') }}"><i class="fa fa-google left small" ></i>Ingresar con Google<a>
            </center>
         </div>
       </div>
      
     
    </div>
  </div>
</div>
          
@endsection
