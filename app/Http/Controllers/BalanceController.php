<?php

namespace App\Http\Controllers;

use App\Http\Requests\Balance\StoreBalanceRequest;
use App\Http\Requests\Balance\UpdateBalanceRequest;
use App\Models\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function store(StoreBalanceRequest $request)
    {
        $request->validated();
        $balance = Balance::create([
            'credito_id'    => $request->credito_id,
            'total_activo'  => $request->total_activo,
            'total_pasivo'  => $request->total_pasivo,
            'patrimonio'    => $request->patrimonio ,
            'fecha'         => $request->fecha ,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $balance = Balance::where('credito_id', $request->credito_id)->first();
        return $balance;
    }
    public function update(UpdateBalanceRequest $request)
    {
        $request->validated();

        Balance::where('credito_id', $request->credito_id)->update([
            'total_activo'      => $request->total_activo,
            'total_pasivo'      => $request->total_pasivo,
            'patrimonio'        => $request->patrimonio,
            'fecha'             => $request->fecha,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $balance = Balance::where('id', $request->id)->first();
        $balance->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Balance::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
