<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\AtencionDiagnostico;
use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $diagnostico = Diagnostico::create([
            'codigo'                    => $request->codigo,
            'atencion_id'               => $request->atencion_id,
            'diagnostico_id'            => $request->diagnostico_id,
            'tipo_ingreso_egresos_id'   => $request->tipo_ingreso_egresos_id,
            'tipo_diagnostico_id'       => $request->tipo_diagnostico_id,
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
        $diagnostico = Diagnostico::where('id', $request->id)->first();
        return $diagnostico;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $diagnostico = Diagnostico::where('id',$request->id)->first();

        $diagnostico->nombre           = $request->nombre;
        $diagnostico->save();

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
        $diagnostico = Diagnostico::where('id', $request->id)->first();
        $diagnostico->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Medicamento eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $diagnosticos = Diagnostico::get();
        return $diagnosticos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Diagnostico::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(codigo) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('descripcion LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('descripcion', 'asc')
        ->paginate($paginacion);
    }
    public function obtenerDiagnosticosPorAtencion(Request $request){
        return AtencionDiagnostico::with('diagnostico:id,codigo,descripcion')
        ->where('atencion_id', $request->atencion_id)->get();
    }
}
