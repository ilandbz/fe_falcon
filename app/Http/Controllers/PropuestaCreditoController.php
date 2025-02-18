<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropuestaCredito\StorePropuestaCreditoRequest;
use App\Http\Requests\PropuestaCredito\UpdatePropuestaCreditoRequest;
use App\Models\PropuestaCredito;
use Illuminate\Http\Request;

class PropuestaCreditoController extends Controller
{
    public function store(StorePropuestaCreditoRequest $request)
    {
        $request->validated();
        $propuesta = PropuestaCredito::create([
            'credito_id'        => $request->credito_id,
            'unidad_familiar'   => $request->unidad_familiar,
            'experiencia_cred'  => $request->experiencia_cred,
            'destino_prest'     => $request->destino_prest ,
            'referencias'       => $request->referencias ,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $propuesta = PropuestaCredito::where('credito_id', $request->credito_id)->first();
        return $propuesta;
    }
    public function update(UpdatePropuestaCreditoRequest $request)
    {
        $request->validated();

        PropuestaCredito::where('credito_id', $request->credito_id)->update([
            'unidad_familiar'      => $request->unidad_familiar,
            'experiencia_cred'     => $request->experiencia_cred,
            'destino_prest'        => $request->destino_prest,
            'referencias'          => $request->referencias,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $propuesta = PropuestaCredito::where('id', $request->id)->first();
        $propuesta->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return PropuestaCredito::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
