<?php

namespace App\Http\Controllers;

use App\Http\Requests\Negocio\StoreNegocioRequest;
use App\Http\Requests\Negocio\UpdateNegocioRequest;
use App\Models\Negocio;
use Illuminate\Http\Request;

class NegocioController extends Controller
{
    public function store(StoreNegocioRequest $request){
        Negocio::create([
            'cliente_id' => $request->cliente_id,
            'razonsocial' => $request->razonsocial,
            'ruc' => $request->ruc,
            'tel_cel' => $request->tel_cel,
            'tipo_actividad_id' => $request->tipo_actividad_id,
            'descripcion' => $request->descripcion,
            'inicioactividad' => $request->inicioactividad,
            'ubicacion_id' => $request->ubicacion_id,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente'
        ], 200);
    }
    public function show(Request $request){
        $registro = Negocio::with([
            'tipo_actividad:id,nombre',
            'ubicacion:id,tipo,ubigeo,tipovia,nombrevia,nro,interior,mz,lote,tipozona,nombrezona,referencia',
            'ubicacion.distrito:id,ubigeo,nombre,provincia_id',
            'ubicacion.distrito.provincia:id,nombre,departamento_id',
            'ubicacion.distrito.provincia.departamento:id,nombre',
            ])->where('id', $request->id)->first();
        return $registro;
    }

    public function todos(){
        $negocio = Negocio::get();
        return $negocio;
    }
    
    public function porCliente(Request $request){
        $negocio = Negocio::where('cliente_id', $request->cliente_id)->get();
        return $negocio;
    }

    public function update(UpdateNegocioRequest $request){
        $negocio = Negocio::findOrFail($request->id);
        $negocio->update([
            'credito_id' => $request->credito_id,
            'usuario_id' => $request->usuario_id,
            'resultado' => $request->resultado,
            'fechahora' => $request->fechahora,
            'comentario' => $request->comentario,
            'tasainteres' => $request->tasainteres,
        ]);
        $negocio->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Se guardo Exito'
        ],200);
    }
    public function destroy(Request $request){
        $negocio = Negocio::where('id', $request->id)->first();
        $negocio->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Eliminado satisfactoriamente'
        ],200);
    }

}
