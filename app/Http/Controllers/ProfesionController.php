<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profesion\StoreProfesionRequest;
use App\Http\Requests\Profesion\UpdateProfesionRequest;
use App\Models\Profesion;
use Illuminate\Http\Request;

class ProfesionController extends Controller
{
    public function store(StoreProfesionRequest $request)
    {
        $request->validated();

        $menu = Profesion::create([
            'nombre'    => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Profesion Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = Profesion::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdateProfesionRequest $request)
    {
        $request->validated();

        $menu = Profesion::where('id',$request->id)->first();
        $menu->nombre           = $request->nombre;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Profesion modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $menu = Profesion::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Profesion eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $menus = Profesion::get();
        return $menus;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Profesion::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
