<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoMenu\StoreGrupoMenuRequest;
use App\Http\Requests\GrupoMenu\UpdateGrupoMenuRequest;
use App\Models\GrupoMenu;
use Illuminate\Http\Request;

class GrupoMenuController extends Controller
{
    public function store(StoreGrupoMenuRequest $request)
    {
        $grupomenu = GrupoMenu::create([
            'titulo'    => $request->titulo,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $grupomenu = GrupoMenu::where('id', $request->id)->first();
        return $grupomenu;
    }

    public function update(UpdateGrupoMenuRequest $request)
    {
        $request->validated();

        $grupomenu = GrupoMenu::where('id',$request->id)->first();

        $grupomenu->titulo           = $request->titulo;
        $grupomenu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $grupomenu = GrupoMenu::where('id', $request->id)->first();
        $grupomenu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $grupomenus = GrupoMenu::get();
        return $grupomenus;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return GrupoMenu::where('titulo', 'LIKE', '%' . $buscar . '%')
        ->paginate($paginacion);
    }
}
