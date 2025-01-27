<?php

namespace App\Http\Controllers;

use App\Models\PrecioMedicamento;
use Illuminate\Http\Request;

class PrecioMedicamentoController extends Controller
{
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        $codigo=$request->codigo;//periodo
        return PrecioMedicamento::where('CPERIODO', $codigo)
        ->join('medicamentos', 'precio_medicamentos.medicamento_id', '=', 'medicamentos.id')
        ->orderBy('medicamentos.med_Nombre', 'asc')
        ->paginate($paginacion);
    }
    public function obtenerPrecios(Request $request)
    {
        return PrecioMedicamento::with('medicamento:id,med_CodMed,med_Nombre')
        ->where('medicamento_id', $request->medicamento_id)->get();
    }
}
