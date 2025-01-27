<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Procedimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcedimientoController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $procedimiento = Procedimiento::create([
            'fua' => $request->fua,
            'lote' => $request->lote,
            'numero' => $request->numero,
            'paciente_id' => $request->paciente_id, 
            'procedimiento_id' => $request->procedimiento_id,
            'cantidad' => $request->cantidad,
            'precio_aplicado' => $request->precio_aplicado,
            'total' => $request->total,
            'periodo'   => $request->anho,
            'estado'    => $request->estado,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Role Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $procedimiento = Procedimiento::where('id', $request->id)->first();
        return $procedimiento;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $procedimiento = Procedimiento::where('id',$request->id)->first();

        $procedimiento->nombre           = $request->nombre;
        $procedimiento->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Procedimiento modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $procedimiento = Procedimiento::where('id', $request->id)->first();
        $procedimiento->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Procedimiento eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $procedimientos = Procedimiento::get();
        return $procedimientos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Procedimiento::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(PRCD_ID_PROCEDIMIENTO) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('PRCD_V_DESPROCEDIMIENTO LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('PRCD_V_CODPRO_MINSA LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('PRCD_V_CODPROCEDIMIENTO LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('PRCD_V_DESPROCEDIMIENTO', 'asc')
        ->paginate($paginacion);
    }
    public function insumos(Request $request){
        $codprocedimiento = mb_strtoupper($request->codigo);

        $procedimiento = Procedimiento::with('insumos')->where('PRCD_V_CODPROCEDIMIENTO', $codprocedimiento)->first();
        
        if (!$procedimiento) {
            return response()->json([
                'message' => 'Procedimiento no encontrado'
            ], 404);
        }
        //$insumos = $procedimiento->insumos;
        return response()->json($procedimiento);
    } 
}
