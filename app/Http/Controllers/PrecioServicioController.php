<?php

namespace App\Http\Controllers;

use App\Models\PrecioServicio;
use Illuminate\Http\Request;

class PrecioServicioController extends Controller
{
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        $codigo=$request->codigo;//periodo
        return PrecioServicio::where('periodo', $codigo)
        ->join('servicios', 'precio_servicios.servicio_id', '=', 'servicios.id')
        ->orderBy('servicios.descripcion', 'asc')
        ->paginate($paginacion);
    }
}
