<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Categoria;
use DB;

class CategoriasController extends Controller
{
    public function index(Request $request)
    {
        //Vista principal de  categorias
        $request->user()->authorizeRoles('Administrador');
        $categorias = Categoria::orderBy('NombreCategoria', 'DESC')->paginate(6);
        return view('categorias.categorias', array('categorias' => $categorias));
    }

    public function register(Request $request)
    {
        //Metodo qe dirige al formulario
        $request->user()->authorizeRoles('Administrador');
        return view('categorias.register');
    }
     
        
    public function store(Request $request)
    {
        //Metodo para guardar los datos
        $categorias = new Categoria;
        $categorias->NombreCategoria = $request->input('nombrecategoria');
        $categorias->Descripcion = $request ->input('descripcioncategoria');
        if($categorias->save())
        {
            return  back()->with('msg', 'Datos guardados correctamente');
        }
        else
        {
            return back()->with('msgerror', 'Los datos no pudieron ser guardados');
        }
    }

    public function DeleteCategoria($id)
    {
       $categorias = Categoria::where('IdCategoria','=', $id)->first();
       return response()->json($categorias->toArray());
    }

    //Metodo para Eliminar categorias
    public function delete (Request $request,$id){
        if ($request->ajax()) {
            //Descomentar para Eliminar
            DB::table('tbcategorias')->where('IdCategoria', '=', $id)->delete();
            return response()->json([
                'mensaje' => 'Datos eliminados correctamente'
            ]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }

    public function edit($id)
    {
        //metodo que recupera los datos de la categoria que se va a editar
       $categorias = Categoria::where('IdCategoria','=', $id)->first();
       return response()->json($categorias->toArray());
    }

    //Metodo para actualizar una categoria
     public function update (Request $request,$id){
        if ($request->ajax()) {
            $categorias = Categoria::find ($id);
            $categorias->fill([
                'NombreCategoria' => $request->NombreCategoria,
                'Descripcion' => $request->Descripcion,
            ]);
            $categorias->save();
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
