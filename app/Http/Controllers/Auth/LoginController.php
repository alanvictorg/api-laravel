<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Entities\User;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\CouldNotCreateTokenException;

//use App\Exceptions\InvalidCredentialsException;
//use App\Exceptions\InvalidSerialNumberException;
//use App\Exceptions\TokenNotProvidedException;
use Namshi\JOSE\JWT;
use JWTAuth;
use Tymon\JWTAuth\Facades;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws CouldNotCreateTokenException
     */
    public function login(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];

        $usuario = User::where('email', $email)
            ->firstOrFail();

        if (Hash::check($password, $usuario->password)) {
            $customClaims = ["id" => $usuario->id];
            try {
//                $payload = Facades\JWTFactory::make($customClaims);
                $token = JWTAuth::fromUser($usuario);

                return response()->json( $usuario
                );
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                throw new CouldNotCreateTokenException();
            }
        } else {
            throw new InvalidCredentialsException();
        }
    }
}
