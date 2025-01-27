<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Establecimiento;
use Illuminate\Http\Request;

class EstablecimientoController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $Establecimiento = Establecimiento::create([
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
        $Establecimiento = Establecimiento::where('id', $request->id)->first();
        return $Establecimiento;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $Establecimiento = Establecimiento::where('id',$request->id)->first();

        $Establecimiento->nombre           = $request->nombre;
        $Establecimiento->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Establecimiento modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $Establecimiento = Establecimiento::where('id', $request->id)->first();
        $Establecimiento->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Establecimiento eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $Establecimientos = Establecimiento::get();
        return $Establecimientos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Establecimiento::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('nombre', 'asc')
        ->paginate($paginacion);
    }
}
