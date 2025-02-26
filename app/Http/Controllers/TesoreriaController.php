<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tesoreria\StoreTesoreriaRequest;
use App\Http\Requests\Tesoreria\UpdateTesoreriaRequest;
use App\Models\Tesoreria;
use Illuminate\Http\Request;

class TesoreriaController extends Controller
{
    public function store(StoreTesoreriaRequest $request)
    {
        $registro = Tesoreria::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $registro = Tesoreria::where('id', $request->id)->first();
        return $registro;
    }
    
    public function obtener(Request $request)
    {
        $registro = Tesoreria::where('id', $request->id)->first();
        return response()->json([
            'role' => $registro,
        ],200);     
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTesoreriaRequest $request)
    {
        $registro = Tesoreria::where('id',$request->id)->first();

        $registro->nombre           = $request->nombre;
        $registro->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $registro = Tesoreria::where('id', $request->id)->first();
        $registro->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Tesoreria::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
