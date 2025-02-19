<?php

namespace App\Http\Controllers;

use App\Models\DetVentaPG;
use Illuminate\Http\Request;

class DetVentaPGController extends Controller
{
    public function store(StoreBalanceRequest $request)
    {
        $request->validated();
        $detventa = DetVentaPG::create([
            'credito_id' => $request->credito_id,
            'nroproducto' => $request->nroproducto,
            'descripcion' => $request->descripcion,
            'unidadmedida' => $request->unidadmedida,
            'preciounit' => $request->preciounit,
            'primaprincipal' => $request->primaprincipal,
            'primasecundaria' => $request->primasecundaria,
            'primacomplement' => $request->primacomplement,
            'matprima' => $request->matprima,
            'manoobra1' => $request->manoobra1,
            'manoobra2' => $request->manoobra2,
            'manoobra' => $request->manoobra,
            'costoprimount' => $request->costoprimount,
            'prodmensual' => $request->prodmensual,
            'ventastotales' => $request->ventastotales,
            'totcostoprimo' => $request->totcostoprimo,
            'margenventas' => $request->margenventas,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $detventa = DetVentaPG::where('credito_id', $request->credito_id)->get();
        return $detventa;
    }
    public function update(UpdateBalanceRequest $request)
    {
        $request->validated();

        DetVentaPG::where('credito_id', $request->credito_id)->update([
            'credito_id' => $request->credito_id,
            'nroproducto' => $request->nroproducto,
            'descripcion' => $request->descripcion,
            'unidadmedida' => $request->unidadmedida,
            'preciounit' => $request->preciounit,
            'primaprincipal' => $request->primaprincipal,
            'primasecundaria' => $request->primasecundaria,
            'primacomplement' => $request->primacomplement,
            'matprima' => $request->matprima,
            'manoobra1' => $request->manoobra1,
            'manoobra2' => $request->manoobra2,
            'manoobra' => $request->manoobra,
            'costoprimount' => $request->costoprimount,
            'prodmensual' => $request->prodmensual,
            'ventastotales' => $request->ventastotales,
            'totcostoprimo' => $request->totcostoprimo,
            'margenventas' => $request->margenventas,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $detventa = DetVentaPG::where('id', $request->id)->first();
        $detventa->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }
}
