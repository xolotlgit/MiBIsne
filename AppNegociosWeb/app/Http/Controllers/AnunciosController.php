<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Anuncio;
use App\Negocios;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use DB;

class AnunciosController extends Controller
{
    //Metodo que devuelve el lisatdo de anuncios y los envia a la vista con paginacion 
    public function index(Request $request)
    {
        $request->user()->authorizeRoles('Administrador');
        $anuncios = DB::table('tbanuncios')
            ->join('tbnegocios', 'tbanuncios.IdNegocio', '=', 'tbnegocios.IdNegocio')
            ->join('users', 'tbnegocios.IdUsuario', '=' , 'users.id')
            /*->where('tbanuncios.bitStatus', '=', "1")*/
            ->select('tbanuncios.*', 'tbnegocios.Nombre_Negocio', 'users.Nombre_User', 'users.Apellidos')
            ->orderBy('created_at', 'DESC')->paginate(8);
            //dd($anuncios); 
        return view('anuncios.index', array('anuncios'=>$anuncios));
    }
    
    //Metodo que devuelve al anuncio que coincida con la busqueda que el usuario introdujo
    public function findAnuncio($name)
    {
       // $anuncios = Anuncio::Where('Nombre_Anuncio', 'like', '%' . $name . '%')->get();
        $anuncios = DB::table('tbanuncios')
            ->join('tbnegocios', 'tbanuncios.IdNegocio', '=', 'tbnegocios.IdNegocio')
            ->Where('tbanuncios.Nombre_Anuncio', 'like', '%' . $name . '%')
            ->orwhere('tbnegocios.Nombre_Negocio', 'like', '%' . $name . '%')
            ->get();
        return response()->json($anuncios->toArray());
    }
    public function register(Request $request)
    {
        $request->user()->authorizeRoles('Administrador');
        $mesInicio = date('d/m/Y'); 
        $negocio = Negocios::all();
        return view('anuncios.register', array('negocio'=>$negocio,'mesInicio'=>$mesInicio));
    }

    public function edit($id)
    {
       //Metodo que recupera los datos del anuncio seleccinado para su edición
       $anuncio = Anuncio::where('IdAnuncio','=', $id)->first();
       
       return response()->json($anuncio->toArray());
    }

    //Metodo para actualizar los datos de anuncio
     public function update (Request $request,$id){
         //dd($request);
        if ($request->ajax()) {
            $anuncio = Anuncio::find ($id);

            $anuncio->fill([
                'Nombre_Anuncio' => $request->Nombre_Anuncio,
                'Fecha_Inicio' => $request->Fecha_Inicio,
                'Fecha_Fin' => $request->Fecha_Fin,
                'bitStatus' => $request->Status,
            ]);
            $anuncio->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
        
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            //Instancia table NEgocios
            $anuncio = new Anuncio();
            //ruta Imagenes
            $path = public_path(). '/images/anuncios/';

            //Ultimo Id de Anuncio En DB
            $lastid= Anuncio::all();
            $valorincre =$lastid->last()->IdAnuncio + 1;
            //Get imagen 1
            $image = Input::file('file');
            $filename  = $request->Nombre_Anuncio . '_' . $request->IdNegocio . "_" . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('images/anuncios/' . $filename);
            \Image::make($image->getRealPath())->resize(468, 249)->save($path);

            /*$image = Input::file('file');
            $filename  = $request->Nombre_Anuncio . '_' . $request->IdNegocio . "_" . $valorincre . '.' . $image->getClientOriginalExtension();
            //Copy imagenes a carpeta public
            $imagen = \Image::make($filename->getRealPath())->resize(468, 249)->save($path);
            $ImgUrl = $path . $filename;*/
            
            
            //Parse de Fechas a formato MySQL
            $Fech_Ini_Suscrip = $request->Fecha_Inicio;
            $Fech_Ini_Suscrip = Carbon::createFromFormat('d/m/Y', $Fech_Ini_Suscrip)->toDateString();
            $Fech_Fin_Suscrip = $request->Fecha_Fin;
            $Fech_Fin_Suscrip = Carbon::createFromFormat('d/m/Y', $Fech_Fin_Suscrip)->toDateString();

            //instancia a Create de Negocios DB
            Anuncio::create([
                'Imagen_Url' => $path,
                'IdNegocio' => $request->IdNegocio,
                'Nombre_Anuncio' => $request->Nombre_Anuncio,
                'Fecha_Inicio' => $Fech_Ini_Suscrip,
                'Fecha_Fin' => $Fech_Fin_Suscrip,
                'bitStatus' => 1,
            ]);
            //si datos Guardados Return Success
            return response()->json([
                'mensaje' => 'Anuncio Guardado correctamente'
            ]);//si datos no guardados return error
        } else {
            return response()->json([
                'mensaje' => 'Error intentelo mas tarde'
            ]);
        }//Return de validacion if /else
        return response()->json($request->toArray());
    }

    //Metodo que recupera la informacion del anuncio a eliminar
    public function DeleteAnuncio($id)
    {
       $anuncios = Anuncio::where('IdAnuncio','=', $id)->first();
       return response()->json($anuncios->toArray());
    }

    //Metodo para ELIMINAR ANUNCIOS
    public function delete (Request $request,$id){
        if ($request->ajax()) {
            //Descomentar para Eliminar
            DB::table('tbanuncios')->where('IdAnuncio', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Datos eliminados correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }
}
