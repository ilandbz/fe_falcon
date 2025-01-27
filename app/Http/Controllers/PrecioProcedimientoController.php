<?php

namespace App\Http\Controllers;

use App\Models\PrecioProcedimiento;
use Illuminate\Http\Request;

class PrecioProcedimientoController extends Controller
{
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        $codigo=$request->codigo;//periodo
        return PrecioProcedimiento::where('periodo', $codigo)
        ->join('procedimientos', 'precio_procedimientos.procedimiento_id', '=', 'procedimientos.id')
        ->where(function ($query) use ($buscar) {
            $query->whereRaw('UPPER(procedimientos.PRCD_V_DESPROCEDIMIENTO) LIKE ?', ["%{$buscar}%"]);
        })
        ->orderBy('procedimientos.PRCD_V_DESPROCEDIMIENTO', 'asc')
        ->paginate($paginacion);
    }
    public function obtenerPrecios(Request $request)
    {
        return PrecioProcedimiento::with('procedimiento:id,PRCD_ID_PROCEDIMIENTO,PRCD_V_DESPROCEDIMIENTO,PRCD_V_CODPRO_MINSA,PRCD_V_CODPROCEDIMIENTO')
        ->where('procedimiento_id', $request->procedimiento_id)->get();
    }
}
