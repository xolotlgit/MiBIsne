@extends('layouts.app')

@section('content')
<div class="container">
    <!--Card Principal de Opciones-->
      <div class="card">
        <div class="card-content"></br>
            <span class="card-title activator grey-text text-darken-4"><b>MI BISNE</b><i class="material-icons right">more_vert</i></span>
        </div>
        <div class="card-reveal"></br>
            <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
            <p class="revelal-home-t">BIENVENIDO A MI BISNE !!</p>
            <p class="revelal-home-content">Este es el menú de opciones a las que tienes acceso como administrador, a través de ellas podrás controlar y gestionar los contenidos de la aplicación.</p>
            <p class="revelal-home-content">Si necesita ayuda puede consultar el siguiente enlace:</p>
            <p><a href="#"><i class="material-icons prefix left">computer</i>Introducción a Mi Bisne</a></p>
       </div>
       <div class="card-content">
          <div class="panel-body">
              <div class="row">
                <!--inicio de los cards-->
                  <div class="col s12 m6 l6">
                     <div class="card horizontal">
                        <div class="card-image col l4" href="/listado">
                          <a href="/listado"><img src="images/Menu/negocio.png"></a>
                        </div>
                        <div class="card-stacked">
                           <div class="card-content">
                              <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>NEGOCIOS</b></span></div>
                            </div>
                            <div class="card-action">
                              <a class="waves-effect btn" href="/principal">Registar</a>
                              <a class="waves-effect waves-light btn" href="/listado" style="background-color:#E57373;">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s12 m6 l6">
                   <div class="card horizontal">
                        <div class="card-image col l4">
                            <a href="/servicios"><img src="images/Menu/servicios.png"></a>
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>SERVICIOS</b></span></div>
                            </div>
                            <div class="card-action">
                                <a class="waves-effect btn" href="/servicios/register">Registar</a>
                                <a class="waves-effect waves-light btn" href="/servicios" style="background-color:#E57373;">Ver</a>
                            </div>
                       </div>
                   </div>
                </div>
                <div class="col s12 m6 l6">
                    <div class="card horizontal">
                        <div class="card-image col l4">
                            <a href="/categorias"><img src="images/Menu/categorias.png"></a>
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>CATEGORÍAS</b></span></div>
                            </div>
                            <div class="card-action">
                                <a class="waves-effect btn" href="/categorias/register">Registar</a>
                                <a class="waves-effect waves-light btn" href="/categorias" style="background-color:#E57373;">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6">
                    <div class="card horizontal">
                        <div class="card-image col l4">
                            <a href="/contactos"><img src="images/Menu/contacto.png"></a>
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>CONTACTOS</b></span></div>
                            </div>
                            <div class="card-action">
                                <a class="waves-effect btn" href="/contactos/register">Registar</a>
                                <a class="waves-effect waves-light btn" href="/contactos" style="background-color:#E57373;">Ver</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6">
                    <div class="card horizontal">
                        <div class="card-image col l4">
                            <a href="/anuncios"><img src="images/Menu/ofertas.png"></a>
                          </div>
                          <div class="card-stacked">
                              <div class="card-content">
                                  <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>ANUNCIOS</b></span></div>
                              </div>
                              <div class="card-action">
                                  <a class="waves-effect btn" href="/anuncios/register">Registar</a>
                                  <a class="waves-effect waves-light btn btn-secundario" href="/anuncios" style="background-color:#E57373;">Ver</a>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l6">
                    <div class="card horizontal">
                        <div class="card-image col l4">
                            <a href="/ver/usuarios"><img src="images/Menu/usuario.png"></a>
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>USUARIOS</b></span></div>
                            </div>
                            <div class="card-action">
                                <a class="waves-effect waves-light btn col l4" href="/ver/usuarios" style="background-color:#E57373;">Ver</a>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div class="col s12 m6 l6">
                      <div class="card horizontal">
                          <div class="card-image col l4">
                              <a href="/ver/tickets/"><img src="images/Menu/ticket.png"></a>
                          </div>
                          <div class="card-stacked">
                              <div class="card-content">
                                  <div class="pdd-ttl-card"><span class="card-title" style="font-size:21px;"><b>TICKET</b></span></div>
                              </div>
                              <div class="card-action">
                                  <a class="waves-effect waves-light btn col l4" href="/ver/tickets/">Ver</a>
                              </div>
                          </div>
                      </div>
                  </div>
                <!--Fin de los cards-->
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection
