<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

//Rutas Para Menus de Usuarios
Route::get('/musuario', 'UsuariosController@index');
Route::get('/home', 'HomeController@index')->name('home');

//Logueo con Google y Facebook
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');


//Rutas Para la Plantilla Registro de Negocios */
Route::get('/principal', 'NegociosController@index');
Route::get('/listado', 'NegociosController@show');
Route::get('/negoedit', 'NegociosController@edit');
Route::get('/negocios/autousuarios/{name}', 'NegociosController@finduser');
Route::get('/negocios/getuser/{id}', 'NegociosController@getuser');
Route::post('/registronegocios', 'NegociosController@store');
//Ver, editar y eliminar desde el modal
Route::get('/detalles/negocio/{id}', 'NegociosController@verDetalles');
Route::put('/negocio/delete/{id}', 'NegociosController@delete');
Route::post('/negocio/Update/{id}', 'NegociosController@updateNegocio');
//Barra de Busqueda
Route::get('/negocios/autocompNegocios/{name}', 'NegociosController@SearchNegocio');

//RUTAS PARA EL MODULO USUARIO
Route::Resource('/usuarios', 'UsuariosController');
Route::get('/usuario/perfil', 'UsuariosController@perfilUser');
Route::get('/usuario/perfil/{id}/edit','UsuariosController@editPerfilUser');
Route::put('/usuario/perfil/{id}','UsuariosController@UpdatePerfilUser');
Route::get('/ver/usuarios', 'UsuariosController@verUsers');
Route::get('/registrar/negocio', 'UsuariosController@show');
Route::post('/createneg', 'UsuariosController@store');
Route::get('/informacion/usuario', 'UsuariosController@InfoComplete');
Route::post('/usuario', 'UsuariosController@InfoCompleteRegister');
//Ver, editar y eliminar desde el modal
Route::get('/negocio/usuario/{id}', 'UsuariosController@verDetalles');
Route::put('/negocio/delete/{id}', 'UsuariosController@delete');
Route::post('/negocio/Update/{id}', 'UsuariosController@updateNegocio');
//LISTADO de SERVICIOS en el MODULO USUARIO
//Ver y crear servicios desde el modal <MenuUser class="blade php"
Route::get('/Detalles/Servicios/{id}', 'UsuariosController@GetServicios');
Route::get('/Detalle/Servicio/{id}', 'UsuariosController@GetServicio');
Route::put('/Delete/Servicios/{id}', 'UsuariosController@SetDeleteServicios');
Route::post('/Save/Servicios/', 'UsuariosController@SaveServicios');
Route::post('/Update/Servicios/', 'UsuariosController@UpdateServicios');


//Rutas para EDITAR y ELIMINAR USUARIO desde el MODULO ADMIN
Route::get('/usuarios/{id}/edit','UsuariosController@edit');
Route::put('/usuarios/{id}','UsuariosController@update');
Route::get('/ver/usuarios/{id}/delete','UsuariosController@DeleteUsuario');
Route::put('/ver/usuarios/delete/{id}', 'UsuariosController@deleteUser');
//Barra de busqueda USUARIOS->MODULO ADMIN
Route::get('/ver/usuarios/autousuario/{name}', 'UsuariosController@findUser');

//Rutas para el modulo CONTACTOS
Route::get('/contactos', 'ContactoController@index');
Route::get('/contactos/register', 'ContactoController@register');
Route::post('/contactos', 'ContactoController@store');
Route::get('/contactos/{id}/edit','ContactoController@edit');
Route::put('/contactos/{id}','ContactoController@update');
Route::get('/contactos/{id}/delete','ContactoController@DeleteContacto');
Route::put('/contactos/delete/{id}', 'ContactoController@delete');

//Rutas para el modulo Categorias
Route::get('/categorias', 'CategoriasController@index');
Route::get('/categorias/register', 'CategoriasController@register');
Route::post('/categorias', 'CategoriasController@store');
Route::get('/categorias/{id}/edit','CategoriasController@edit');
Route::put('/categorias/{id}','CategoriasController@update');
Route::get('/categorias/{id}/delete','CategoriasController@DeleteCategoria');
Route::put('/categorias/delete/{id}', 'CategoriasController@delete');


//Rutas para el modulo Servicios
//Route::get('/servicios', 'ServiciosController@index');
Route::get('/servicios/register', 'ServiciosController@register');
Route::Resource('servicios','ServiciosController');
Route::get('/servicios/{id}/delete','ServiciosController@DeleteService');
Route::put('/servicios/delete/{id}', 'ServiciosController@delete');
Route::get('/servicios/{id}/edit','ServiciosController@edit');
Route::put('/servicios/{id}','ServiciosController@update');
//Busqueda de servicios
Route::get('/servicios/autoservice/{name}', 'ServiciosController@findService');

//Rutas para el modulo Anuncios
Route::get('/anuncios', 'AnunciosController@index');
Route::get('/anuncios/register', 'AnunciosController@register');
Route::post('/anuncios/save', 'AnunciosController@store');
Route::get('/anuncios/{id}/delete','AnunciosController@DeleteAnuncio');
Route::put('/anuncios/delete/{id}', 'AnunciosController@delete');
Route::get('/anuncios/{id}/edit','AnunciosController@edit');
Route::put('/anuncios/{id}','AnunciosController@update');
//Barra de Busqueda de anuncios
Route::get('/anuncios/autoanuncio/{name}', 'AnunciosController@findAnuncio');

//Email
Route::Resource('email', 'EmailController');

//Tickets
Route::get('/ver/tickets/','TicketsController@index');
Route::POST('/consulta/tickets/','TicketsController@GetUsers');
Route::POST('/notification/tickets','TicketsController@SenNotification');