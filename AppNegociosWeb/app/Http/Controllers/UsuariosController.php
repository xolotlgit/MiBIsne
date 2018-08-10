<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Categoria;
use App\Negocios;
use App\Servicios;
use DB;
use Carbon\Carbon;

class UsuariosController extends Controller
{
    public function index(Request $request)
    {
        //Metodo que carga el menu del modulo usuarios
        //$request->user()->authorizeRoles(['Negociante']);
        $user = Auth::user()->id;
        $negocios = Negocios::Where('IdUsuario', '=', $user)->get();
        return view('menuUser', array('negocios'=>$negocios));   
    }

    public function perfilUser(Request $request)
    {
        //Metodo para el perfil de usuarios
        //$request->user()->authorizeRoles(['Negociante']);
        $user = Auth::user();
        return view('usuarios.EditarPerfilUsuario',array('user'=> $user));
    }

    public function show(Request $request)
    {
        //Metodo para dirigir al formulario de registro de negocios desde el MODULO USUARIO
        //$request->user()->authorizeRoles(['Negociante']);
        //Calcular la fecha actual para el inicio de la suscripcion
        $mesInicio = date('d/m/Y'); 
        $mesFin = date('d/m/Y', strtotime('+1 month')) ;//Suma un mes para termino de la suscripcion
        //Obtener las categorias
        $categoria = Categoria::all();
        //Regresar la vista con los arreglos de datos
        return view('usuarios.RegistroNegocios', array('categoria'=>$categoria, 'mesInicio'=>$mesInicio,'mesFin'=>$mesFin));
    }

    public function getcategorias()
    {
        //Metodo que obtiene las categorias y las envia a la vista de registro de negocio
        $categoria = Categorias::all();
        return view('negocios.register', array('categoria'=>$categoria));
    }

    public function verDetalles($IdNegocio)
    {
        //Metodo para ver detalles de cada negocio
        $vernegocio = Negocios::where('IdNegocio','=', $IdNegocio)->first();
        return view('menuUser', array('usuarios'=>$usuarios, 'negocios'=>$negocios,'vernegocio'=>$vernegocio));
    }

    //VER USUARIOS DESDE EL MODULO ADMIN
    public function verUsers(Request $request){
        //Acceso solo para el admin ya que esta vista trae todos los usuarios existentes en el sistema
        $request->user()->authorizeRoles(['Administrador']);
        $usuarios  = User::paginate(6);
        return view('usuarios.usuarios', array('usuarios'=>$usuarios));
    }

    //METODO que recupera el id del usuario a eliminar ->MODULO ADMIN
    public function DeleteUsuario($id)
    {
       $usuarios = user::where('id','=', $id)->first();
       return response()->json($usuarios->toArray());
    }

    //Metodo para ELIMINAR USUARIOS->MODULO ADMIN
    public function deleteUser (Request $request,$id){
        if ($request->ajax()) {
            DB::table('users')->where('id', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Datos eliminados correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }

    //Método para REGISTRAR UN NEGOCIO desde la vista de USUARIO
     public function store(Request $request)
    {
        if ($request->ajax()) {
            //Instancia table NEgocios
            $negocio = new Negocios();
            //Instancia Usuario Logueado
            $user = Auth::user();
            //ruta Imagenes
            $path = public_path(). '/images/Negocios/';
        
            //Get imagen 1
            $file1 = $request->file1;
            $imagen1 = \Image::make($file1);
            $nameimg1 = $request->Nombre_Negocio . '_' . $request->id . '_1.' . $file1->getClientOriginalExtension();
            
            if($request->file2 == "null"){
                //Get imagen 1
                $file2 = $request->file1;
                $imagen2 = \Image::make($file1);
                $nameimg2 = $request->Nombre_Negocio . '_' . $request->id . '_1.' . $file1->getClientOriginalExtension();
            }else{
                 //Get imagen 2
                $file2 = $request->file2;
                $imagen2 = \Image::make($file2);
                $nameimg2 = $request->Nombre_Negocio . '_' . $request->id . '_2.' . $file2->getClientOriginalExtension();
            }
           
            if($request->file3 == "null"){
                $file3 = $request->file1;
                $imagen3 = \Image::make($file1);
                $nameimg3 = $request->Nombre_Negocio . '_' . $request->id . '_1.' . $file1->getClientOriginalExtension();
            }else{
                //Get imagen 3
                $file3 = $request->file3;
                $imagen3 = \Image::make($file3);
                $nameimg3 = $request->Nombre_Negocio . '_' . $request->id . '_3.' . $file3->getClientOriginalExtension();
            }            
            
            //Parse de Fechas a formato MySQL
            $Fech_Ini_Suscrip = $request->Fech_Ini_Suscrip;
            $Fech_Ini_Suscrip = Carbon::createFromFormat('d/m/Y', $Fech_Ini_Suscrip)->toDateString();
            $Fech_Fin_Suscrip = $request->Fech_Ini_Suscrip;
            $Fech_Fin_Suscrip = Carbon::createFromFormat('d/m/Y', $Fech_Fin_Suscrip)->toDateString();
            //instancia a Create de Negocios DB
            Negocios::create([
                'Imagen1' => $path.$nameimg1,
                'Imagen2' => $path.$nameimg2,
                'Imagen3' => $path.$nameimg3,
                'IdUsuario' => $user->id,
                'Nombre_Negocio' => $request->Nombre_Negocio,
                'Descripcion' => $request->Descripcion,
                'Direccion_N' => $request->Direccion_N,
                'Horario' => $request->Horario,
                'Telefono_F' => $request->Telefono_F,
                'Telefono_M' => $request->Telefono_M,
                'Email_N' => $request->Email_N,
                'Sitio_Web' => $request->Sitio_Web,
                'Facebook' => $request->Facebook,
                'Instagram' => $request->Instagram,
                'Twitter' => $request->Twitter,
                'Otra_Red' => $request->Otra_Red,
                'Posicion_GPS' => 'posicion',
                'Tags' => $request->Tags,
                'Fech_Ini_Suscrip' => $Fech_Ini_Suscrip,
                'Fech_Fin_Suscrip' => $Fech_Fin_Suscrip,
                'IdCategoria' => $request->IdCategoria,
                'bitStatus' => 1,
            ]);
            //Copy imagenes a carpeta public
            $imagen1->save($path.$nameimg1);
            $imagen2->save($path.$nameimg2);
            $imagen3->save($path.$nameimg3);
            //si datos Guardados Return Success
            return response()->json([
                'mensaje' => 'Guardado correctamente'
            ]);//si datos no guardados return error
        } else {
            return response()->json([
                'mensaje' => 'Error intentelo mas tarde'
            ]);
        }//Return de validacion if /else
        return response()->json($request->toArray());
    }


    //Método para ACTUALIZAR un NEGOCIO desde la VISTA de USUARIO
     public function updateNegocio(Request $request, $id){
         
        if($request->ajax())
        {
            $negocio = Negocios::find($id);
            $negocio->fill([
                'Nombre_Negocio' => $request->Nombre_Negocio,
                'Descripcion' => $request->Descripcion_N,
                'Direccion_N' => $request->Direccion_N,
                'Horario' => $request->Horario,
                'Telefono_F' => $request->Telefono_F,
                'Telefono_M' => $request->Telefono_M,
                'Email_N' => $request->Email_N,
                'Sitio_Web' => $request->Sitio_Web,
                'Facebook' => $request->Facebook,
                'Instagram' => $request->Instagram,
                'Twitter' => $request->Twitter,
                'Otra_Red' => $request->Otra_Red,
            ]);
            $negocio->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }//END if $request->ajax
    }

    //RECUPERA LA INFROMACION DEL USUARIO PARA EDITAR desde el MODULO ADMIN
    public function edit($id)
    {
       $usuarios = User::where('id','=', $id)->first();
       return response()->json($usuarios->toArray());

    }
    
    //ACTUALIZAR INFORMACION DE USUARIO DESDE MODULO ADMIN
     public function update (Request $request,$id){
        if ($request->ajax()) {
            $usuarios = User::find ($id);
            $usuarios->fill([
                'Nombre_User' => $request->Nombre_User,
                'Apellidos' => $request->Apellidos,
                'Direccion' => $request->Direccion,
                'Telefono1' => $request->Telefono1,
                'Telefono2' => $request->Telefono2,
                'Alias_Usuario' => $request->Alias_Usuario,
                'password' => bcrypt($request->password),
                'Clave' => $request->Clave,
            ]);
            $usuarios->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
     }

    //Metodo para buscar usuarios, devuelve los datos que correspodan con la busqueda realizada
    //El administrador podra buscar por nombre de usuario y nombre del negocio.
    public function findUser($name)
    {
        $usuarios = User::Where('Nombre_User', 'like', '%' . $name . '%')
        ->orwhere('Apellidos', 'like', '%' . $name . '%')
        ->get();
        return response()->json($usuarios->toArray());
    }

    //Metodo para ELIMINAR NEGOCIOS en el MODULO de USUARIOS
    public function delete (Request $request,$id){
        if ($request->ajax()) {
            //Descomentar para Eliminar
            DB::table('tbanuncios')->where('IdNegocio', '=', $id)->delete();
            DB::table('tbnegocios')->where('IdNegocio', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Negocio Eliminado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }
    
    //Metodo QUE RECUPERA la informacion para que el USUARIO EDITE SU PERFIL
    public function editPerfilUser($id){
       $usuarios = User::where('id','=', $id)->first();
       return response()->json($usuarios->toArray());

    }
    //METODO QUE ACTUALIZA EL PERFIL DE USUARIO->MODULO USUARIO
    public function UpdatePerfilUser (Request $request,$id){
        if ($request->ajax()) {
            $usuarios = User::find ($id);
            $usuarios->fill([
                'Nombre_User' => $request->Nombre_User,
                'Apellidos' => $request->Apellidos,
                'Direccion' => $request->Direccion,
                'Telefono1' => $request->Telefono1,
                'Telefono2' => $request->Telefono2,
                'Alias_Usuario' => $request->Alias_Usuario,
                'Clave' => $request->Clave,
                'password' => Hash::make($request->input('password')),
                'Token'  => '0',
            ]);
            $usuarios->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
     }

     
    //GET  SERVICIOS DEL NEGOCIO->MODULO USUARIO
    public function GetServicios($IdNegocio){
        $servicios = Servicios::where('IdNegocio','=', $IdNegocio)->get();
        return response()->json($servicios->toArray());
    }

    //GET DATOS DEL SERVICIO SELECCIONADO->MODULO USUARIO
    public function GetServicio($IdServicio){
        $servicio = Servicios::where('IdServicio','=', $IdServicio)->get();
        return response()->json($servicio->toArray());
    }

    //GUARDAR SERVICIOS DESDE EL MODAL->MODULO USUARIO
    public function SaveServicios(Request $request){
        //dd($request);
        if ($request->ajax()) {
            //Create de Servicio
            Servicios::create([
                'IdNegocio' => $request->id,
                'Nombre_Servicio' => $request->nombre,
                'Descripcion_S' => $request->descripcion,
                'Costo' => $request->precio,
            ]);
            //si datos Guardados Return Success
            return response()->json([
                'mensaje' => 'Servicio Guardado correctamente'
            ]);//si datos no guardados return error
        } else {
            return response()->json([
                'mensaje' => 'Error intentelo mas tarde'
            ]);
        }//Return de validacion if /else
        return response()->json($request->toArray());
    }

    //ACTUALIZAR SERVICIOS DESDE EL MODAL DEL NEGOCIO->MODULO USUARIO
    public function UpdateServicios(Request $request){
        if($request->ajax())
        {
            $servicio = Servicios::find($request->id);
            $servicio->fill([
                'Nombre_Servicio' => $request->nombre,
                'Descripcion_S' => $request->descripcion,
                'Costo' => $request->precio,
            ]);
            $servicio->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }//END if $request->ajax
    }

    //ELIMINAR SERVICIOS DE UN NEGOCIOS->MODULO USUARIO
    public function SetDeleteServicios(Request $request,$IdServicioDelete){
        if ($request->ajax()) {
            //Descomentar para Eliminar
            $servicio = Servicios::find($IdServicioDelete);
            $servicio->delete();
            return response()->json([
                'mensaje' => 'Servicio Eliminado Correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }

    public function InfoComplete(){
        $user = Auth::user();
        return view('usuarios.CompletarInformacion', array('user'=> $user));
    }

    public function InfoCompleteRegister(Request $request){
        $usuario = Auth::user();
        $user = User::find($usuario->id);
        $user->Tipo_User = 'Negociante';
        $user->Nombre_User = $request->input('name');
        $user->Apellidos  = $request->input('apellidos');
        $user->Direccion  = $request->input('direccion');
        $user->Telefono1  = $request->input('tel1');
        $user->Telefono2  = $request->input('tel2');
        $user->Posicion_GPS  = 'Longitud: -98.75913109999999_Latitud: 20.1010608';
        $user->email  = $usuario->email;
        $user->Alias_Usuario  = $request->input('alias');
        $user->Clave  = $request->input('password');
        $user->password  = Hash::make($request->input('password'));
        $user->Token  = '0';
        if($user->save()){
            $negocios = Negocios::Where('IdUsuario', '=', $usuario->id)->get();
            return view('menuUser', array('negocios'=>$negocios));
        }else{
            return view('CompletarInformacion');
        }
        
    }
}
