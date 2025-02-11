<?php

namespace App\Http\Controllers;

use App\Http\Requests\Credito\StoreCreditoRequest;
use App\Http\Requests\Credito\UpdateCreditoRequest;
use App\Models\Credito;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public function store(StoreCreditoRequest $request)
    {
        $request->validated();
        $credito = Credito::create([
            'cliente_id'    => $request->cliente_id,
            'agencia_id'    => $request->agencia_id,
            'asesor_id'     => $request->asesor_id,
            'estado'        => $request->estado,
            'fecha_reg'     => $request->fecha_reg,
            'tipo'          => $request->tipo,
            'monto'         => $request->monto,
            'producto'      => $request->producto,
            'frecuencia'    => $request->frecuencia,
            'plazo'         => $request->plazo,
            'medioorigen'   => $request->medioorigen,
            'dondepagara'   => $request->dondepagara ?? 'NINGUNO',
            'fuenterecursos'=> $request->fuenterecursos,
            'tasainteres'   => $request->tasainteres ?? 0.00,
            'total'         => $request->total ?? 0.00,
            'costomora'     => $request->costomora ?? 0.00,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Credito Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $credito = Credito::where('id', $request->id)->first();
        return $credito;
    }
    public function update(UpdateCreditoRequest $request)
    {
        $request->validated();

        $credito = Credito::where('id',$request->id)->first();

        $credito->nombre           = $request->nombre;
        $credito->slug             = $request->slug;
        $credito->icono            = $request->icono;
        $credito->padre_id         = $request->padre_id;
        $credito->grupo_id         = $request->grupo_id;
        $credito->orden            = $request->orden;
        $credito->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Credito modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $credito = Credito::where('id', $request->id)->first();
        $credito->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $creditos = Credito::with('grupo:id,titulo')->get();
        return $creditos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Credito::paginate($paginacion);
    }
}
