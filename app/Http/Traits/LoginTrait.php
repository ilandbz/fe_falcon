<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
trait LoginTrait
{
    public function validarLogin(LoginRequest $request){
        $request->validated();
        $credenciales = ['name' => $request->username, 'password' => $request->password, 'es_activo' => 1];
        $user = User::where('name',$request->username)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                if(auth()->attempt($credenciales)){
                    $user = auth()->user();
                    $usuario = User::where('id',$user->id)->first();
                    $success['user'] = $usuario->id;
                    $success=JWT::encode($success,env('VITE_SECRET_KEY'), 'HS256');
                    return response()->json($success,200);
                } else {
                    return response()->json([
                        'errors' => ['name' => 'Usuario Suspendido']
                    ],422);
                }
            }
            else {
                return response()->json([
                    'errors' => ['password' => 'Contraseña Incorrecta']
                ],422);
            }
        }
        else {
            return response([
                'errors' => [ 'name' => 'Nombre de Usuario no válido']
            ], 422);
        }
    }
}