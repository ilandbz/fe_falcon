<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerdidasGanancias\StorePerdidasGananciasRequest;
use App\Http\Requests\PerdidasGanancias\UpdatePerdidasGananciasRequest;
use App\Models\PerdidaGanancia;
use Illuminate\Http\Request;

class PerdidaGananciaController extends Controller
{
    public function store(StorePerdidasGananciasRequest $request)
    {
        //$request->validated();
        $balance = PerdidaGanancia::create([
            'credito_id'    => $request->credito_id,
            'ventas' => $request->ventas,
            'costo' => $request->costo,
            'utilidad' => $request->utilidad,
            'costonegocio' => $request->costonegocio,
            'utiloperativa' => $request->utiloperativa,
            'otrosing' => $request->otrosing,
            'gast_fam' => $request->gast_fam,
            'utilidadneta' => $request->utilidadneta,
            'utilnetdiaria' => $request->utilnetdiaria,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $balance = PerdidaGanancia::where('credito_id', $request->credito_id)->first();
        return $balance;
    }
    public function update(UpdatePerdidasGananciasRequest $request)
    {
        $request->validated();

        PerdidaGanancia::where('credito_id', $request->credito_id)->update([
            'ventas'        => $request->ventas,
            'costo'         => $request->costo,
            'utilidad'      => $request->utilidad,
            'costonegocio'  => $request->costonegocio,
            'utiloperativa' => $request->utiloperativa,
            'otrosing'      => $request->otrosing,
            'otrosegr'      => $request->otrosegr,
            'gast_fam'      => $request->gast_fam,
            'utilidadneta'  => $request->utilidadneta,
            'utilnetdiaria' => $request->utilnetdiaria,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $balance = PerdidaGanancia::where('id', $request->id)->first();
        $balance->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }
}
