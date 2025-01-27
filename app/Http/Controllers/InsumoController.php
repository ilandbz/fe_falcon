<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Insumo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $insumo = Insumo::create([
            'fua' => $request->fua,
            'lote' => $request->lote,
            'numero' => $request->numero,
            'paciente_id' => $request->paciente_id, 
            'insumo_id' => $request->insumo_id,
            'cantidad' => $request->cantidad,
            'precio_aplicado' => $request->precio_aplicado,
            'total' => $request->total,
            'periodo'   => $request->periodo,
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
        $insumo = Insumo::where('id', $request->id)->first();
        return $insumo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $insumo = Insumo::where('id',$request->id)->first();

        $insumo->nombre           = $request->nombre;
        $insumo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Insumo modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $insumo = Insumo::where('id', $request->id)->first();
        $insumo->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Insumo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $insumos = Insumo::get();
        return $insumos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Insumo::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(ins_CodIns) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('ins_Nombre LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('ins_FormaFarmaceutica LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('ins_Nombre', 'asc')
        ->paginate($paginacion);
    }
}
