<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConsultaApiNetController extends Controller
{
    public function buscarDniRuc(Request $request){
        $tipo = $request->tipo;
        $numero = $request->numero;

        // Obtener credenciales desde config/services.php
        $token = config('services.apis-net.token');
        $baseUrl = config('services.apis-net.url');

        // Construir la URL según el tipo de consulta
        $endpoint = ($tipo == 'dni') ? "reniec/dni?numero=$numero" : "sunat/ruc?numero=$numero";
        $url = $baseUrl . $endpoint;

        // Hacer la solicitud HTTP con el token en el header
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => "Bearer $token"
        ])->get($url);

        return response()->json($response->json(), $response->status());

    }
}
