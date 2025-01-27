<?php

namespace App\Http\Controllers;
use App\Http\Traits\LoginTrait;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use LoginTrait;
    public function login(LoginRequest $request){
        return $this->validarLogin($request);
    }
    public function logout()
    {
        auth()->guard('web')->logout();
        // auth()->user()->tokens->each(function($token,$key){
        //     $token->delete()  ;
        // });
        return response()->json([
            'ok' => 1,
            'mensaje' =>'Sessión cerrada Satisfactoriamiente'
        ], 200);
    }
}
