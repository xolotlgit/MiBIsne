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
                  
           @endif
         </ul>
      </div>
    </nav>
  @yield('content')
</div>
</body>
<!--Footer-->
<footer class="page-footer">
      <div class="footer-copyright">
         <div class="container center">
            <p class="text-footer-2">Copyright © Xólotl Creative Labs, S de R.L. de C.V.</p>
         </div>
      </div>
 </footer>
<!--Fin Footer-->
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

