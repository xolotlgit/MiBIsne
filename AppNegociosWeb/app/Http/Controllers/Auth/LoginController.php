<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\SocialAccountService;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    //Redireccionar despues del login
    protected $redirectTo = '/home';
    protected $redirectSocial = '/informacion/usuario';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        // Comprobar si el input coincide con el formato de E-mail
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'Alias_Usuario';

        return [
            $field => $login,
            'password' => $request->input('password')
        ];
    }

    public function username()
    {
        return 'login';
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    //Metodos para logeos con google y facebook
    public function handleProviderCallback($provider)
    {   
        if($provider == "google")
        {
            $user = Socialite::driver($provider)->stateless()->user();
        }
        else
        { 
            $user = Socialite::driver($provider)->user();
        }
        
        // All Providers
        $user->getId();
        $user->getNickname();
        $nombre=$user->getName();
        $user->getAvatar();
        
        $authUser = $this->buscarGuardar($user, $provider);
        \Auth::login($authUser, true);
        return redirect($this->redirectSocial);
    }

    //Metodo que hace el registro de un usuario que se logue con google o facebook
    public function buscarGuardar($user, $provider)
    {
        $authUser = User::where('provider_id','=',$user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'Nombre_User'     => $user->name,
            'Apellidos' => " ",
            'Tipo_User' => "Negociante",
            'Direccion' => " ",
            'Telefono1' => "0000000000",
            'Telefono2' => "0000000000",
            'Posicion_GPS' => "No existe información",
            'Alias_Usuario' => $user->name,
            'Clave' => " ",
            'password' => " ",
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'Token'=> "0",
        ]);
        
    }

}
