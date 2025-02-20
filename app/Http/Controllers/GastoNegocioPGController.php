<?php

namespace App\Http\Controllers;

use App\Http\Requests\GastoNegocio\StoreGastoNegocioRequest;
use App\Http\Requests\GastoNegocio\UpdateGastoNegocioRequest;
use App\Models\GastoNegocioPG;
use Illuminate\Http\Request;

class GastoNegocioPGController extends Controller
{
    public function store(StoreGastoNegocioRequest $request)
    {
        $request->validated();
        $balance = GastoNegocioPG::create([
            'credito_id'            => $request->credito_id,
            'alquiler'              => $request->alquiler,
            'servicios'             => $request->servicios,
            'personal'              => $request->personal,
            'sunat'                 => $request->sunat,
            'transporte'            => $request->transporte,
            'gastosfinancieros'     => $request->gastosfinancieros,
            'otros'                 => $request->otros,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $balance = GastoNegocioPG::where('credito_id', $request->credito_id)->first();
        return $balance;
    }
    public function update(UpdateGastoNegocioRequest $request)
    {
        $request->validated();

        GastoNegocioPG::where('credito_id', $request->credito_id)->update([
            'credito_id'            => $request->credito_id,
            'alquiler'              => $request->alquiler,
            'servicios'             => $request->servicios,
            'personal'              => $request->personal,
            'sunat'                 => $request->sunat,
            'transporte'            => $request->transporte,
            'gastosfinancieros'     => $request->gastosfinancieros,
            'otros'                 => $request->otros,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $balance = GastoNegocioPG::where('credito_id', $request->credito_id)->first();
        $balance->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }



}
