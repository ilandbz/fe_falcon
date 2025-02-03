<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agencia\StoreAgenciaRequest;
use App\Http\Requests\Agencia\UpdateAgenciaRequest;
use App\Models\Agencia;
use Illuminate\Http\Request;

class AgenciaController extends Controller
{
    public function store(StoreAgenciaRequest $request)
    {
        $request->validated();
        $role = Agencia::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Agencia Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $role = Agencia::where('id', $request->id)->first();
        return $role;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgenciaRequest $request)
    {
        $request->validated();

        $role = Agencia::where('id',$request->id)->first();

        $role->nombre           = $request->nombre;
        $role->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Agencia modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $role = Agencia::where('id', $request->id)->first();
        $role->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Agencia eliminado satisfactoriamente'
        ],200);
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Agencia::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
    public function todos(){
        return Agencia::all();
    }
}
