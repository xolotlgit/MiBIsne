<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Categorias;
use App\Negocios;
use App\Anuncio;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->Tipo_User == 'Administrador'){
            //Cambiar el status del negocio cuando  su suscripcion este vencida
            $FechaFin= date('Y/m/d', strtotime('-1 day')) ; // resta 1 día
            $fecha = Negocios::where('Fech_Fin_Suscrip', '<', $FechaFin)->get();
            
            $tokens = array();
            foreach($fecha as $fecha){
                $IdUser = User::where('id', '=', $fecha->IdUsuario)->get();
                foreach($IdUser as $IdUser){
                    $IdUser =$IdUser->Token;
                }
                $url = 'https://fcm.googleapis.com/fcm/send';
                $fields = array (
                    'registration_ids' => array (
                        $IdUser
                    ),
                    'data' => array (
                        'title'   => "Suscripción vencida",
                        'message' => "Esperamos que esté disfrutando de los servicios que le ofrece Mi Bisne. \n Le invitamos a renovar la suscripción vencida de su negocio ".$fecha->Nombre_Negocio,
                        'contacto' => Auth::user()->Telefono1,
                        'type'    => "laravelnego",
                    )
                );
                $fields = json_encode ( $fields );

                $headers = array (
                        'Authorization: key=' . "AIzaSyDd90OkmWTUjyuvDvizwFNySglV0DqMf2I",
                        'Content-Type: application/json'
                );

                $ch = curl_init ();
                curl_setopt ( $ch, CURLOPT_URL, $url );
                curl_setopt ( $ch, CURLOPT_POST, true );
                curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
                curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

                $result = curl_exec ( $ch );
                
                curl_close ( $ch );
            }         
            
            //Cambiar el status del anuncio cuando termine su vigencia
            $FinVigencia= date('Y/m/d', strtotime('-1 day')) ; // resta 1 día
            $VigenciaAnuncio = DB::table ('tbanuncios')->where('Fecha_Fin', '<', $FinVigencia)->get();
            //dd($VigenciaAnuncio);
            $IdAnuncioL =array();
            foreach ($VigenciaAnuncio as $VigenciaAnuncio) {
                $IdAnuncioL = array_prepend($IdAnuncioL, $VigenciaAnuncio->IdAnuncio);
            }
            foreach($IdAnuncioL as $IdAnuncioL){
                $VigenciaAnuncio = Anuncio::find($IdAnuncioL);
                $VigenciaAnuncio->bitStatus = 0;
                $VigenciaAnuncio->save();
            }
            return view('home');
        }
        else if(Auth::user()->Tipo_User == 'Negociante'){
            $usuarios  = User::all();
            $user = Auth::user()->id;
            $negocios = Negocios::Where('IdUsuario', '=', $user)->get();
            return view('menuUser', array('usuarios'=>$usuarios, 'negocios'=>$negocios));  
        }else{
            dd("No se Encuentra");
        }
    }
    
}
