<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Categoria;
use App\Negocios;
use App\User;
use DB;
use Carbon\Carbon;

class NegociosController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->authorizeRoles('Administrador');
        //Calcular la fecha actual para el inicio de la suscripcion
        $mesInicio = date('d/m/Y'); 
        $mesFin = date('d/m/Y', strtotime('+1 month')) ;//Suma un mes para termino de la suscripcion 
        //Obtener las categorias
        $categoria = Categoria::all();
        //Regresar la vista con los arreglos de datos
        return view('negocios.create', array('categoria'=>$categoria,'mesInicio'=>$mesInicio,'mesFin'=>$mesFin));
    }

    public function show(Request $request)
    {
        $request->user()->authorizeRoles('Administrador');
        $negocios = DB::table('tbnegocios')->orderBy('Nombre_Negocio', 'ASC')->paginate(6);
        return view('negocios.listado', array('negocios'=>$negocios));
    }
    
    public function edit()
    {
        return view('negocios.edit');
    }
    
    public function verDetalles($id)
    {
        $negocios = Negocios::Where('IdNegocio', '=', $id)->get();
        return response()->json($negocios->toArray());    
    }

    //Metodo con los criterios de busqueda para hacer la busqueda
    public function finduser($name)
    {
        $usuarios = User::Where('Nombre_User', 'like', '%' . $name . '%')->orWhere('email', 'like', '%' . $name . '%')->orWhere('Alias_Usuario', 'like', '%' . $name . '%')->get();
        return response()->json($usuarios->toArray());
    }

    //Obtiene en usuario que se selecciono
    public function getuser($id)
    {
        $usuarios = User::Where('id', '=', $id)->get();
        return response()->json($usuarios->toArray());
    }

    //Metodo para la barra de busqueda en la vista del listado de negocios
    public function SearchNegocio($name)
    {
        $negocios = Negocios::Where('Nombre_Negocio', 'like', '%' . $name . '%')->get();
        return response()->json($negocios->toArray());
    }

    //Metodo para Guardar Negocios recive parametros de la vista create
    public function store(Request $request)
    {

        if ($request->ajax()) {
            //Instancia table NEgocios
            $negocio = new Negocios();
            $user = $request->id;
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
                'IdUsuario' => $request->id,
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

    //Metodo para Eliminar Negocios
    public function delete (Request $request,$id){
        if ($request->ajax()) {
            //Descomentar para Eliminar
            //DB::table('tbanuncios')->where('IdNegocio', '=', $id)->delete();
            //DB::table('tbnegocios')->where('IdNegocio', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Negocio Eliminado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }

    //Método para registrar un negocio desde la vista de usuario
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
}

