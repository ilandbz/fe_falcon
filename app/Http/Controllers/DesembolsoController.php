<?php

namespace App\Http\Controllers;

use App\Http\Requests\Desembolso\StoreDesembolsoRequest;
use App\Http\Requests\Desembolso\UpdateDesembolsoRequest;
use App\Models\Credito;
use App\Models\CreditosCancelar;
use App\Models\Desembolso;
use App\Models\SeguroDesgravamen;
use Illuminate\Http\Request;

class DesembolsoController extends Controller
{
    public function store(StoreDesembolsoRequest $request)
    {

        $desembolso = Desembolso::create([
            'credito_id'     => $request->credito_id,
            'fecha'          => $request->fecha,
            'hora'           => $request->hora,
            'user_id'        => $request->user_id,
            'descontado'     => $request->descontado,
            'totalentregado' => $request->totalentregado
        ]);
        
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Desembolso Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = Desembolso::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdateDesembolsoRequest $request)
    {
        $desembolso = Desembolso::where('id', $request->id)->first();
        if ($desembolso) {
            $desembolso->credito_id     = $request->credito_id;
            $desembolso->fecha          = $request->fecha;
            $desembolso->hora           = $request->hora;
            $desembolso->user_id        = $request->user_id;
            $desembolso->descontado     = $request->descontado;
            $desembolso->totalentregado = $request->totalentregado;
            $desembolso->save();
        
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Desembolso actualizado correctamente'
            ], 200);
        } else {
            return response()->json([
                'ok' => 0,
                'mensaje' => 'Desembolso no encontrado'
            ], 404);
        }

    }

    public function destroy(Request $request)
    {
        $desembolso = Desembolso::where('id', $request->id)->first();
        $desembolso->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Desembolso eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Desembolso::with(['padre:id,nombre', 'grupo:id,titulo'])->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

    public function obtenerDescuentos(Request $request){
        $montosolicitado = $request->monto;
        $credito_id= $request->credito_id;
        $montoseguro = SeguroDesgravamen::where('credito_id', $credito_id)->value('monto');
        $montoconfigoenti = $montosolicitado * 0.10;
        // $montocreditos=CreditosCancelar::where('credito_id')
    }
}
