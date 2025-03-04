<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsultaApiNetController extends Controller
{
    public function buscarDniRuc(Request $request){
        $tipo = $request->tipo;
        $numero = $request->numero;
        $token = 'TU_TOKEN_AQUI'; // Reemplaza con tu token
    
        if ($tipo == 'dni') {
            $url = "https://api.apis.net.pe/v2/reniec/dni?numero=$numero";
        } else {
            $url = "https://api.apis.net.pe/v2/sunat/ruc?numero=$numero";
        }
    
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->get($url);
    
        return response()->json($response->json(), $response->status());


    }
}
