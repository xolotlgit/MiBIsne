<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use DB;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function index(){
        return view('tickets.index');
    }

    public function GetUsers(Request $request){
        if ($request->ajax()) {
            $FechaMin = $request->FechMin;
            //$FechaMin =  Carbon::createFromFormat($format, (new DateTime($value))->format('Y-m-d H:i:s'));
            $FechaMax = $request->FechMax;            
            //$FechaMax =  Carbon::createFromFormat('Y-m-d', $FechaMax);
            $tickets = Ticket::whereBetween('FechaAdquisicion', [$FechaMin, $FechaMax])->get();
            
            $IdsUsuario = array();
            
            foreach ($tickets as $tickets) {
                $IdsUsuario = array_prepend($IdsUsuario, $tickets->IdUsuario);
            }

            $ClearArray = array_unique($IdsUsuario);
            $Valores = array();
            $count = array();
            foreach ($ClearArray as $ClearArray){
                $usuarios = User::where('id','=', $ClearArray)->first();

            $totaltickets = DB::table('tbtickets')
                     ->where('IdUsuario', $usuarios->id)
                     ->select(DB::raw('count(*) as TotalT'))
                     ->first();            
            $usuarios = array("Total" => $totaltickets->TotalT,"id"=>$usuarios->id,"Nombre_User"=>$usuarios->Nombre_User,"Apellidos"=>$usuarios->Apellidos,"Direccion"=>$usuarios->Direccion,"email"=>$usuarios->email);
            $Valores = array_prepend($Valores, $usuarios);
            }
            //dd($Valores);
            
            return response()->json(["Valores" => $Valores]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }

    public function SenNotification(Request $request){
        if ($request->ajax()) {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $usuarios = User::where('email','=', $request->email)->first();

            $fields = array (
                'registration_ids' => array (
                    $usuarios->Token
                ),
                'data' => array (
                    'title'     => "Mi Bisne: Usted a sido seleccionado ganador",
                    'message'     => $request->body,
                    'contacto' => Auth::user()->Telefono1,
                    'type'    => "laravelticket",
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
            //echo $result;
            curl_close ( $ch );


            return response()->json(["google" => $result]);
        }else{
            return response()->json([
                'mensaje' => 'Ha Ocurrido Un Error'
            ]);
        }
    }
}
