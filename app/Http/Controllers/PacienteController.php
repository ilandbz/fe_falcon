<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(){
        $pacientes = Paciente::with(['tipo_documento:id,descripcion', 'sexo:id,descripcion'])
        ->orderBy('ape_paterno', 'asc')
        ->paginate(80);
        return inertia('Pacientes/Inicio', ['pacientes' => $pacientes]);
    }
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $paciente = Paciente::create([
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
        $paciente = Paciente::where('id', $request->id)->first();
        return $paciente;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $paciente = Paciente::where('id',$request->id)->first();

        $paciente->nombre           = $request->nombre;
        $paciente->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $paciente = Paciente::where('id', $request->id)->first();
        $paciente->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $pacientes = Paciente::get();
        return $pacientes;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Paciente::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(CONCAT(ape_paterno, " ", ape_materno, " ", primer_nombre, " ", otros_nombres)) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('nro_documento LIKE ?', ['%'.$buscar.'%']);
        })
        ->orderBy('ape_paterno', 'asc')
        ->paginate($paginacion);
    }
}
