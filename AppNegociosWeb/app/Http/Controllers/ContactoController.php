<?php

namespace App\Http\Controllers;
use App\Contacto;
use Illuminate\Http\Request;
use DB;

class ContactoController extends Controller
{
    public function index()
    {
        //Metodo que muestra la vista principal de contactos
        $contactos = Contacto::all();
        return view('contactos.contactos', array('contactos' => $contactos));
    }

    public function register()
    {
        //metodo que redirige al formulario de registro
        return view('contactos.register');
    }

    //Metodo para registrar contactos
    public function store(Request $request)
    {
        //Instancia de clase
        $contactos = new Contacto;
        $contactos->Nombre = $request->input('nombre');
        $contactos->Correo  = $request->input('email');
        $contactos->Telefono1  = $request->input('telefono1');
        $contactos->Telefono2  = $request->input('telefono2');
        $contactos->Direccion_Url  = 'pendiente';
        if($contactos->save())
        {
            return  back()->with('msg', 'Datos guardados correctamente');
        }
        else
        {
            return back()->with('msgerror', 'Los datos no pudieron ser guardados');
        }
    }

    public function edit($id)
    {
       //Metodo que recupera los datos del contacto seleccinado para su edicion
       $contactos = Contacto::where('IdContacto','=', $id)->first();
       return response()->json($contactos->toArray());
    }

    //Metodo para actualizar los datos de contacto
     public function update (Request $request,$id){
         //dd($request);
        if ($request->ajax()) {
            $contactos = Contacto::find ($id);
            $contactos->fill([
                'Nombre' => $request->Nombre,
                'Correo' => $request->Correo,
                'Telefono1' => $request->Telefono1,
                'Telefono2' => $request->Telefono2,
            ]);
            $contactos->save();
            return response()->json([
                'mensaje' => 'Actualizado correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
        //return redirect('/contactos');
        //Instancia de clase
       
    }

    //Metodo que recupera el id del contacto a ekiminar
    public function DeleteContacto($id)
    {
       $contactos = Contacto::where('IdContacto','=', $id)->first();
       return response()->json($contactos->toArray());
    }

    //Metodo para Eliminar servicios
    public function delete (Request $request,$id){
        if ($request->ajax()) {
            //Descomentar para Eliminar
            DB::table('tbcontactos')->where('IdContacto', '=', $id)->delete();
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
