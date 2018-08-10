<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="htm">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{ config('Mi Bisne', 'Mi Bisne') }}</title>
      <link rel="Shortcut Icon" href="{{ asset('/images/ico.ico')}}" type="image/x-icon" />
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

  <body class="tam">
      <div id="app">
          <nav>
              <div class="nav-wrapper">
                  <a href="/home" class="brand-logo">
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
                        <li><a href="/home">Inicio<i class="material-icons left">home</i></a></li>
                        <!--dropdown negocios-->
                        <li><a class="dropdown-button" href="#!" data-activates="negocios">Negocios <i class="material-icons left">business</i></a></li>
                        <ul id="negocios" class="dropdown-content">
                            <li><a href="/principal">Registrar</a></li>
                            <li><a href="/listado">Ver</a></li>
                        </ul>  
                        <!--dropdown Usuarios-->
                        <li><a class="dropdown-button" href="#!" data-activates="usuarios">Usuarios<i class="material-icons left">person</i></a></li>
                            <ul id="usuarios" class="dropdown-content">
                                <li><a href="/ver/usuarios">Ver usuarios</a></li>
                            </ul>  
                        <!--dropdown servicios-->
                        <li><a class="dropdown-button" href="#!" data-activates="servicios">Servicios<i class="material-icons left">work</i></a></li>
                            <ul id="servicios" class="dropdown-content">
                                <li><a href="/servicios/register">Registrar</a></li>
                                <li><a href="/servicios">Ver</a></li>
                            </ul>  
                        <!--dropdown contactos-->
                        <li><a class="dropdown-button" href="#!" data-activates="contactos">Contactos <i class="material-icons left">contacts</i></a></li>
                            <ul id="contactos" class="dropdown-content">
                                <li><a href="/contactos/register">Registrar</a></li>
                                <li><a href="/contactos">Ver</a></li>
                            </ul>  
                        <!--dropdown categorias-->
                        <li><a class="dropdown-button" href="#!" data-activates="categorias">Categorias<i class="material-icons left">create</i></a></li>
                            <ul id="categorias" class="dropdown-content">
                                <li><a href="/categorias/register">Registrar</a></li>
                                <li><a href="/categorias">Ver</a></li>
                            </ul>
                        <!--dropdown anuncios-->
                        <li><a class="dropdown-button" href="#!" data-activates="anuncios">Anuncios<i class="material-icons left">shopping_cart</i></a></li>
                            <ul id="anuncios" class="dropdown-content">
                                <li><a href="/anuncios/register">Registrar</a></li>
                                <li><a href="/anuncios">Ver</a></li>
                            </ul>
                        <!--dropdown anuncios-->
                        <li><a class="dropdown-button" href="#!" data-activates="ticket">Tickets<i class="material-icons left">local_activity</i></a></li>
                            <ul id="ticket" class="dropdown-content">
                                <li><a href="/ver/tickets/">Ver</a></li>
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
                      <li class="bold"><a  href="/home" class="collapsible-header waves-effect waves-teal">MENU PRINCIPAL<i class="material-icons prefix">home</i></a></li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">NEGOCIOS<i class="material-icons prefix">business</i></a>
                          <div class="collapsible-body">
                              <ul>
                                  <li><a href="/principal">Registrar</a></li>
                                  <li><a href="/listado">Ver registros</a></li>
                              </ul>
                          </div>
                      </li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">SERVICIOS<i class="material-icons prefix">work</i></a>
                          <div class="collapsible-body">
                              <ul>
                                  <li><a href="/servicios/register">Registrar</a></li>
                                  <li><a href="/servicios">Ver registros</a></li>
                              </ul>
                          </div>
                      </li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">CATEGORÍAS<i class="material-icons prefix">create</i></a>
                          <div class="collapsible-body">
                              <ul>
                                  <li><a href="/categorias/register">Registrar</a></li>
                                  <li><a href="/categorias">Ver registros</a></li>
                              </ul>
                          </div>
                      </li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">CONTACTOS<i class="material-icons prefix">contacts</i></a>
                          <div class="collapsible-body">
                              <ul>
                                  <li><a href="/contactos/register">Registrar</a></li>
                                  <li><a href="/contactos">Ver registros</a></li>
                              </ul>
                          </div>
                      </li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">ANUNCIOS<i class="material-icons prefix">shopping_cart</i></a>
                          <div class="collapsible-body">
                              <ul>
                                  <li><a href="/anuncios/register">Registrar</a></li>
                                  <li><a href="/anuncios">Ver registros</a></li>
                              </ul>
                          </div>
                      </li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">TICKETS<i class="material-icons prefix">local_activity</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="/ver/tickets/">Ver registros</a></li>
                            </ul>
                        </div>
                      </li>
                      <li class="bold"><a class="collapsible-header waves-effect waves-teal">USUARIOS<i class="material-icons prefix">person</i></a>
                          <div class="collapsible-body">
                              <ul>
                                  <li><a href="/ver/usuarios">Ver registros</a></li>
                              </ul>
                          </div>
                      </li>
                  </ul>
               @endif
            </ul>
        </div>
    </nav>
  @yield('content')
</div>
<!--Footer-->
  <div class="page-footer">
      <footer>
          <div class="container">
              <div class="row">
                  <div class="col s12 m5 l5">
                      <h5 class="text-footer">REDES SOCIALES</h5>
                      <div class="text-footer-2 col s6 m4 l6">
                          <ul>
                              <li><a class="grey-text text-lighten-3" href="#!"><i class="fa fa-facebook prefix left small"></i>Facebook</a></li></br>
                              <li><a class="grey-text text-lighten-3" href="#!"><i class="fa fa-instagram left small"></i>Instagram</a></li></br>
                          </ul>
                      </div>
                      <div class="text-footer-2 col s6 m5 l6">
                          <ul>
                              <li><a class="grey-text text-lighten-3" href="#!"><i class="fa fa-twitter prefix left small"></i>Twitter</a></li></br>
                              <li><a class="grey-text text-lighten-3" href="#!"><i class="material-icons prefix left">play_circle_filled</i>YouTube</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class=" border-f col s6 m3 l3 ">
                      <h5 class="text-footer">DESCARGA</h5>
                      <ul class="text-footer-2">
                          <p>Consigue la aplicación para:</p>
                          <li><a class="grey-text text-lighten-3" href="#!"><i class="material-icons prefix left">phone_android</i>Android</a></li></br>
                      </ul>
                  </div>

                  <div class=" border-f col s6 m3 l3 ">
                      <h5 class="text-footer">AYUDA</h5>
                      <ul class="text-footer-2">
                          <li><a class="grey-text text-lighten-3" href="#!"><i class="material-icons prefix left">computer</i>Introduccion a Mi Bisne</a></li>
                      </ul></br></br>
                  </div>
              </div>
          </div>
          <div class="footer-copyright">
              <div class="container center">
                  <p class="text-footer-2">Copyright © Xólotl Creative Labs, S de R.L. de C.V.</p>
              </div>
          </div>
      </footer>
    </div> <!--Fin Footer-->
  </body>
</html>

 <!-- Scripts -->
  <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/materialize.min.js') }}"></script>
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

