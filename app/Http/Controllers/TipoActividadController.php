<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoActividad\StoreTipoActividadRequest;
use App\Models\TipoActividad;
use Illuminate\Http\Request;

class TipoActividadController extends Controller
{
    public function store(StoreTipoActividadRequest $request)
    {
        $registro = TipoActividad::create([
            'nombre' => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona Registrado satisfactoriamente',
        ],200);
    }
    public function show(Request $request)
    {
        $registro = TipoActividad::where('id', $request->id)->first();
        return $registro;
    }
    public function destroy(Request $request)
    {
        $registro = TipoActividad::where('id', $request->id)->first();
        $registro->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona eliminado satisfactoriamente'
        ],200);
    }
    public function todos(){
        $registros = TipoActividad::get();
        return $registros;
    }
}
