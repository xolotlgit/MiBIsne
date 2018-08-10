<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    //Redireccionar despues de registro
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    //Metodo para validar 
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    //Metodo para crear un nuevo usuario
    protected function create(array $data)
    {
       $user = User::create([
            'Tipo_User' => 'Negociante',
            'Nombre_User' => $data['name'],
            'Apellidos' => $data['apellidos'],
            'Direccion' => $data['direccion'],
            'Telefono1' => $data['tel1'],
            'Telefono2' => $data['tel2'],
            'Posicion_GPS' => 'null',
            'email' => $data['email'],
            'Alias_Usuario' => $data['alias'],
            'Clave' => $data['password'],
            'password' => Hash::make($data['password']),
            //'password' => bcrypt($data['password']),
        ]);
        $user
            ->roles()
            ->attach(Role::where('name', 'Negociante')->first());
        return $user;
    }
}
