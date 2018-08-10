<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Servicios;
use App\Negocios;
use DB;

class ServiciosController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->authorizeRoles('Administrador');
       // $servicios=Servicios::all();
        $negocio = Negocios::all();
        $servicios = DB::table('tbservicios')
            ->join('tbnegocios', 'tbservicios.IdNegocio', '=', 'tbnegocios.IdNegocio')
            ->select('tbservicios.*', 'tbnegocios.Nombre_Negocio')
            ->paginate(6);
        return view('servicios.servicios',array('negocio' => $negocio, 'servicios' => $servicios));
    }

    //Metodo para buscar servicios, recive parametro de texto de la vista create
    public function findService($name)
    {
        //$servicios = Servicios::Where('Nombre_Servicio', 'like', '%' . $name . '%')->get();
        $servicios = DB::table('tbservicios')
            ->join('tbnegocios', 'tbservicios.IdNegocio', '=', 'tbnegocios.IdNegocio')
            ->Where('tbservicios.Nombre_Servicio', 'like', '%' . $name . '%')
            ->orwhere('tbnegocios.Nombre_Negocio', 'like', '%' . $name . '%')
            ->get();
        return response()->json($servicios->toArray());
    }

    public function register(Request $request)
    {
        $request->user()->authorizeRoles('Administrador');
        $negocio = Negocios::all();
        return view('servicios.register', array('negocio' => $negocio));
    }

    //Metodo para el registro del Usuarios
    public function store(Request $request){
        //Instancia a la clase servicios
        $servicios = new Servicios;
        $servicios->IdNegocio=$request->IdNegocio;        
        $servicios->Nombre_Servicio = $request->input('nombreservicio');
        $servicios->Descripcion_S = $request ->input('descripcionservicio');
        $servicios->Costo = $request ->input('costoservicio');
        if( $servicios->save())
        {
            return  back()->with('msg', 'Datos guardados correctamente');
        }
        else
        {
            return back()->with('msgerror', 'Los datos no pudieron ser guardados');
        }
    }

    public function DeleteService($id)
    {
       $servicios = Servicios::where('IdServicio','=', $id)->first();
       return response()->json($servicios->toArray());
    }

    //Metodo para Eliminar servicios
    public function delete (Request $request,$id){
    
        if ($request->ajax()) {
            //Descomentar para Eliminar
            DB::table('tbservicios')->where('Idservicio', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Datos eliminados correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }
    //metodo que regresa el servicio en base al id que recibe
    public function edit($id)
    {
       $servicios = Servicios::where('IdServicio','=', $id)->first();
       return response()->json($servicios->toArray());
    }

    //Metodo que actualiza el registro
    public function update (Request $request,$id){
        if ($request->ajax()) {
            $servicios = Servicios::find ($id);
            $servicios->fill([
                'Id_Negocio' => $request->Id_Negocio,
                'Nombre_Servicio' => $request->Nombre_Servicio,
                'Descripcion_S' => $request->Descripcion_S,
                'Costo' => $request->Costo,
            ]);
            $servicios->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
     }
}
