<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;
use Redirect;

class EmailController extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        //'g-recaptcha-response' => 'required|recaptcha',
        Mail::send('contactos.info',$request->all(), function($msj) {
            $msj->subject('Correo MyBisne');
            $msj->to('negocioslocales01@gmail.com');
        });

        return  back()->with('msg', 'Mensaje enviado correctamente');
        return Redirect::to('home');
    
    }
}
