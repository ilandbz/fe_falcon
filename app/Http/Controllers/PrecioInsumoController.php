<?php

namespace App\Http\Controllers;

use App\Models\PrecioInsumo;
use Illuminate\Http\Request;

class PrecioInsumoController extends Controller
{
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        $codigo=$request->codigo;//periodo
        return PrecioInsumo::where('CPERIODO', $codigo)
        ->join('insumos', 'precio_insumos.insumo_id', '=', 'insumos.id')
        ->orderBy('insumos.ins_Nombre', 'asc')
        ->paginate($paginacion);
    }
    public function obtenerPrecios(Request $request)
    {
        return PrecioInsumo::with('insumo:id,ins_CodIns,ins_Nombre,ins_FormaFarmaceutica,ins_Presen,ins_Concen')
        ->where('insumo_id', $request->insumo_id)->get();
    }
}
