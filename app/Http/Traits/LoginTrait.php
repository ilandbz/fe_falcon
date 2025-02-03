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
                    $usuario->load('roles');
                    $usuario->load('agencias');
                    $success['user'] = $user->id;
                    $success['roleid'] = $usuario->roles->first()->id ?? 10;// si no encuentra el rol el primero sera invitado
                    $success['agenciaid'] = $usuario->agencias->first()->id ?? 0;
                    $success=JWT::encode($success,env('VITE_SECRET_KEY'), 'HS256');
                    return response()->json($success,200);
                } else {
                    return response()->json([
                        'errors' => ['username' => 'Usuario Suspendido']
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
                'errors' => [ 'username' => 'Nombre de Usuario no válido']
            ], 422);
        }
    }
    public function cambiarRole(Request $request){
        $user = auth()->user();
        $success['user'] = $user->id;
        $success['roleid'] = $request->id; 
        $success['agenciaid'] = $request->agenciaid;
        $success=JWT::encode($success,env('VITE_SECRET_KEY'), 'HS256');
        return response()->json($success,200);
    }
    public function cambiarAgencia(Request $request){
        $user = auth()->user();
        $success['user'] = $user->id;
        $success['agenciaid'] = $request->id;
        $success['roleid'] = $request->roleid; 
        $success=JWT::encode($success,env('VITE_SECRET_KEY'), 'HS256');
        return response()->json($success,200);
    }
}