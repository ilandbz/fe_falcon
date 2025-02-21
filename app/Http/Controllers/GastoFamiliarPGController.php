<?php

namespace App\Http\Controllers;

use App\Http\Requests\GastoFamiliar\StoreGastoFamiliarRequest;
use App\Http\Requests\GastoFamiliar\UpdateGastoFamiliarRequest;
use App\Models\GastoFamiliarPG;
use Illuminate\Http\Request;

class GastoFamiliarPGController extends Controller
{
    public function store(StoreGastoFamiliarRequest $request)
    {
        //$request->validated();
        $balance = GastoFamiliarPG::create([
            'credito_id'             => $request->credito_id,
            'alimentacion'           => $request->alimentacion,
            'alquileres'             => $request->alquileres,
            'educacion'              => $request->educacion,
            'servicios'              => $request->servicios,
            'transporte'             => $request->transporte,
            'transporte'             => $request->transporte,
            'salud'                  => $request->salud,
            'otros'                  => $request->otros,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $balance = GastoFamiliarPG::where('credito_id', $request->credito_id)->first();
        return $balance;
    }
    public function update(UpdateGastoFamiliarRequest $request)
    {
        //$request->validated();
        GastoFamiliarPG::where('credito_id', $request->credito_id)->update([
            'credito_id'            => $request->credito_id,
            'alimentacion'           => $request->alimentacion,
            'alquileres'             => $request->alquileres,
            'educacion'              => $request->educacion,
            'servicios'              => $request->servicios,
            'transporte'             => $request->transporte,
            'transporte'             => $request->transporte,
            'salud'                  => $request->salud,
            'otros'                  => $request->otros,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $balance = GastoFamiliarPG::where('credito_id', $request->credito_id)->first();
        $balance->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }
}
