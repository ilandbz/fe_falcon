<?php

namespace App\Http\Controllers;

use App\Http\Requests\Evaluacion\StoreEvaluacionRequest;
use App\Http\Requests\Evaluacion\UpdateEvaluacionRequest;
use App\Models\Credito;
use App\Models\Evaluacion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function store(StoreEvaluacionRequest $request){
        $registro = Evaluacion::create([
            'credito_id' => $request->credito_id,
            'usuario_id' => $request->usuario_id,
            'resultado' => $request->resultado,
            'fechahora' => $request->fechahora,
            'comentario' => $request->comentario,
            'tasainteres' => $request->tasainteres,
        ]);

        // if(($request->tiposolicitud=='Paralelo' || ($request->tiposolicitud==='Recurrente Con Saldo' && $cantidadvigentes>1)){
        //     $estado='EVALUACION2';
        // }else{
        //     $estado='APROBADO';
        // }


        $credito=Credito::where('id',$request->credito_id)
        ->update(['estado'=>$request->resultado]);



        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request){
        $registro = Evaluacion::where('id', $request->id)->first();
        return $registro;
    }

    public function update(UpdateEvaluacionRequest $request){
        $user = Evaluacion::findOrFail($request->id);
        $user->update([
            'credito_id' => $request->credito_id,
            'usuario_id' => $request->usuario_id,
            'resultado' => $request->resultado,
            'fechahora' => $request->fechahora,
            'comentario' => $request->comentario,
            'tasainteres' => $request->tasainteres,
        ]);
        $user->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Se guardo Exito'
        ],200);
    }
    public function destroy(Request $request){
        $user = Evaluacion::where('id', $request->id)->first();
        $user->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Eliminado satisfactoriamente'
        ],200);
    }

}
