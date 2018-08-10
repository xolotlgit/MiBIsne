<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{ config('Mi Bisne', 'Mi Bisne') }}</title>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import Google Icon Font-->
      
      <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
      <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{asset('css/material-icons.css')}}">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" media="screen,projection">
      <!--Script-->
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/jquery.min.js"></script>
      
  </head>

  <body>
      <div id="app">
          <nav>
              <div class="nav-wrapper">
                <a href="/musuario" class="brand-logo">
                   <img class="responsive-img" data-activates="mobile-demo center" src="/images/Menu/isotipo.png" style="max-width: 200px; max-width: 150px; padding-left:5px;">
                </a>
                <a href="#" data-activates="mobile-demo" class="button-collapse">
                  <i class="material-icons">menu</i>
                </a>
                <ul class="right hide-on-med-and-down">
                  @if (Auth::guest())
                  <li>
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                  </li>
                  <li>
                    <a href="{{ route('register') }}">Registrate</a>
                  </li>
                  @else
                  <li><a href="/musuario">Inicio<i class="material-icons left">home</i></a></li>
                  <!--dropdown Usuarios-->
                  <li><a href="/usuario/perfil">Mi perfil<i class="material-icons left">person</i></a></li>
                  
                  <!--dropdown negocios-->
                  <li><a class="dropdown-button" href="#!" data-activates="negocios">Registra tu negocio <i class="material-icons left">business</i></a></li>
                    <ul id="negocios" class="dropdown-content">
                      <li><a href="/registrar/negocio">Registrar</a></li>
                      <li><a href="/musuario">Tus negocios</a></li>
                    </ul>  
                  
                  <!--dropdown para logout-->
                  <li>
                    <a class="dropdown-button" href="#!" data-activates="opcionesCuenta">{{ Auth::user()->Alias_Usuario }}
                      <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <ul id="opcionesCuenta" class="dropdown-content">
                      <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
                      </li>
                    </ul>
                  </li>
                  @endif
                </ul>

                <ul class="side-nav" id="mobile-demo">
                  @if (Auth::guest())
                  <li>
                      <a href="{{ route('login') }}">Iniciar sesión</a>
                  </li>
                  <li>
                      <a href="{{ route('register') }}">Registrate</a>
                  </li>
                  @else
                  
                  <li>
                    <a class="dropdown-button" href="#!" data-activates="opcionesCuentaM">{{ Auth::user()->Alias_Usuario }}
                        <i class="material-icons right">arrow_drop_down</i>
                    </a>
                    <ul id="opcionesCuentaM" class="dropdown-content">
                      <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }} </form>
                      </li>
                    </ul>
                  </li>
                  <ul class="collapsible collapsible-accordion">
                    <li class="bold"><a  href="/musuario" class="collapsible-header waves-effect waves-teal">MENU PRINCIPAL<i class="material-icons prefix">home</i></a></li>
                    
                    <li class="bold"><a class="collapsible-header waves-effect waves-teal">REGISTRA TU NEGOCIOS<i class="material-icons prefix">business</i></a>
                        <div class="collapsible-body">
                          <ul>
                            <li><a href="/registrar/negocio">Registrar</a></li>
                            <li><a href="/musuario">Tus negocios</a></li>
                          </ul>
                        </div>
                    </li>
                    <li class="bold"><a class="collapsible-header waves-effect waves-teal" href="/usuario/perfil">Mi perfil<i class="material-icons prefix">person</i></a></li>   
             </ul>
           @endif
         </ul>
      </div>
    </nav>
  @yield('content')
</div>
</body>
<!--Footer-->
<footer class="page-footer">
   <div class="container">
      <div class="row">
           <div class="col s12 m12 l6 ">
              <h5 class="text-footer">CONTACTANOS</h5>
                <form action="{{route('email.store')}}" method="POST">
                {{ csrf_field() }}
                  <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <div class="input-field col s12 m6 l6 ">
                              <i class="material-icons prefix">person</i>
                              <input id="nombre" type="text" class="form-control text-footer-2" name="nombre" value="{{ old('nombre') }}" required placeholder="Nombre">
                              @if ($errors->has('nombre'))
                              <span class="help-block">
                                <strong>{{ $errors->first('nombre') }}</strong>
                              </span>
                              @endif
                        </div>
                    </div>
                     <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="input-field col s12 m6 l6 ">
                              <i class="material-icons prefix">email</i>
                              <input id="email" type="email" class="form-control text-footer-2" name="email" value="{{ old('email') }}" required placeholder="Correo electrónico">
                              @if ($errors->has('email'))
                              <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                              </span>
                              @endif
                        </div>
                    </div>

                 <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                      <div class="input-field col s12">
                          <i class="material-icons prefix">short_tex</i>
                          <textarea id="descripcion" type="descripcion" class="materialize-textarea text-footer-2" name="descripcion" value="{{ old('descripcion') }}" required placeholder="Contenido del email" ></textarea>
                          @if ($errors->has('descripcion'))
                          <span class="help-block">
                            <strong>{{ $errors->first('descripcion') }}</strong>
                          </span>
                          @endif
                     </div>
                 </div>
                 <div class="form-group">
                    <div class="g-recaptcha m-r-capcha" data-sitekey="6LcsxksUAAAAALnA59lctCJFzpuxgO-VO2F7Ujlm"></div>
                    <div class="input-field col s12">
                        <input class="btn tooltipped text-footer-2" data-position="bottom" data-delay="50" data-tooltip="Presione para enviar su email"  style="font-size:18px;" id="submit"  name="submit" type="submit" value="Enviar Email"></br>
                    </div>
                </div>
              </form>
            </div>
            <div class="border-f col s12 m5 l6">
                <h5 class="text-footer">REDES SOCIALES</h5>
                 <div class="text-footer-2 col s12 m6 l6">
                    <ul class="text-footer-2">
                      <li><a class="grey-text text-lighten-3" href="#!"><i class="fa fa-facebook prefix left small"></i>Facebook</a></li></br></br>
                      <li><a class="grey-text text-lighten-3" href="#!"><i class="fa fa-instagram prefix left small"></i>Instagram</a></li></br>
                    </ul>
                 </div>
                <div class="text-footer-2 col s12 m5 l6">
                  <ul>
                     <li><a class="grey-text text-lighten-3" href="#!"><i class="fa fa-twitter prefix left small"></i>Twitter</a></li></br>
                     <li><a class="grey-text text-lighten-3" href="#!"><i class="material-icons prefix left small">play_circle_filled</i>YouTube</a></li>
                  </ul>
                </div>
            </div></br>
            <div class=" border-f col s12 m4 l3 ">
               <h5 class="text-footer">DESCARGA</h5>
               <ul class="text-footer-2">
                  <p>Consigue la aplicación para:</p>
                  <li><a class="grey-text text-lighten-3" href="#!"><i class="material-icons prefix left">phone_android</i>Android</a></li>
               </ul>
            </div>
             <div class=" border-f col s12 m3 l3 ">
               <h5 class="text-footer">AYUDA</h5>
               <ul class="text-footer-2">
                  <li><a class="grey-text text-lighten-3" href="#!"><i class="material-icons prefix left">computer</i>Introduccion a Mi Bisne</a></li>
               </ul></br>
            </div>
        </div>
      </div>
      <div class="footer-copyright">
         <div class="container center">
            <p class="text-footer-2">Copyright © Xólotl Creative Labs, S de R.L. de C.V.</p>
         </div>
      </div>
 </footer>
 <script src='https://www.google.com/recaptcha/api.js'></script>
<!--Fin Footer-->
</html>

 <!-- Scripts -->
 <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
 <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
 <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-database.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase-firestore.js"></script>
  
 <script type="text/javascript">
    $(".button-collapse").sideNav();
    $(".dropdown-button").dropdown();
    $('.modal').modal();
    $('.tooltipped').tooltip({delay: 50});
    $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
    $(".button-collapse").sideNav();
    $(".dropdown-button").dropdown();
    $('.modal').modal();
  });
</script>
@yield('metodosFirebase')
<script type="text/javascript">
    @yield('metodosJava')
</script>

