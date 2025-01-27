<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $servicio = Servicio::create([
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
        $servicio = Servicio::where('id', $request->id)->first();
        return $servicio;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $servicio = Servicio::where('id',$request->id)->first();

        $servicio->nombre           = $request->nombre;
        $servicio->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Servicio modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $servicio = Servicio::where('id', $request->id)->first();
        $servicio->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Servicio eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $servicios = Servicio::get();
        return $servicios;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Servicio::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(codigo) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('descripcion LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('descripcion', 'asc')
        ->paginate($paginacion);
    }
}
