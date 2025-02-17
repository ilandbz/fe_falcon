<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalisisCualitativo\StoreAnalisisCualitativoRequest;
use App\Http\Requests\AnalisisCualitativo\UpdateAnalisisCualitativoRequest;
use App\Models\AnalisisCualitativo;
use Illuminate\Http\Request;

class AnalisisCualitativoController extends Controller
{

    public function store(StoreAnalisisCualitativoRequest $request)
    {
        $request->validated();
        $credito = AnalisisCualitativo::create([
            'cliente_id'       => $request->cliente_id,
            'credito_id'       => $request->credito_id,
            'tipogarantia'     => $request->tipogarantia,
            'cargafamiliar'    => $request->cargafamiliar,
            'riesgoedadmax'    => $request->riesgoedadmax,
            'antecedentescred' => $request->antecedentescred,
            'recorpagoult'     => $request->recorpagoult,
            'niveldesarr'      => $request->niveldesarr,
            'tiempo_neg'       => $request->tiempo_neg,
            'control_integre'  => $request->control_integre,
            'vent_totdec'      => $request->vent_totdec,
            'compsubsector'    => $request->compsubsector,
            'totunidfamiliar'  => $request->totunidfamiliar,
            'totunidempresa'   => $request->totunidempresa,
            'total'            => $request->total,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente',
            'credito_id' => $credito->id,
        ],200);
    }

    public function update(UpdateAnalisisCualitativoRequest $request)
    {
        $request->validated();

        AnalisisCualitativo::where('credito_id', $request->credito_id)->update([
            'tipogarantia'     => $request->tipogarantia,
            'cargafamiliar'    => $request->cargafamiliar,
            'riesgoedadmax'    => $request->riesgoedadmax,
            'antecedentescred' => $request->antecedentescred,
            'recorpagoult'     => $request->recorpagoult,
            'niveldesarr'      => $request->niveldesarr,
            'tiempo_neg'       => $request->tiempo_neg,
            'control_integre'  => $request->control_integre,
            'vent_totdec'      => $request->vent_totdec,
            'compsubsector'    => $request->compsubsector,
            'totunidfamiliar'  => $request->totunidfamiliar,
            'totunidempresa'   => $request->totunidempresa,
            'total'            => $request->total
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Actualizado satisfactoriamente',
        ],200);
    }

    public function show(Request $request)
    {
        $registro = AnalisisCualitativo::where('credito_id', $request->credito_id)->first();
        return $registro;
    }

    public function destroy(Request $request)
    {
        $menu = AnalisisCualitativo::where('credito_id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

}
