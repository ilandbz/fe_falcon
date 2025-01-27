<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Periodo;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $periodo = Periodo::create([
            'nombre'    => $request->nombre,
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
        $periodo = Periodo::where('id', $request->id)->first();
        return $periodo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $periodo = Periodo::where('id',$request->id)->first();

        $periodo->nombre           = $request->nombre;
        $periodo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Medicamento modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $periodo = Periodo::where('id', $request->id)->first();
        $periodo->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Medicamento eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $periodos = Periodo::get();
        return $periodos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Periodo::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(codigo) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('descripcion LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('descripcion', 'asc')
        ->paginate($paginacion);
    }
}
