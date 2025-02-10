<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function store(StoreClienteRequest $request)
    {
        $request->validated();
        if($request->padre_id !='' || $request->padre_id != null){
            $orden = Cliente::maximoHijoId($request->padre_id);
        }else{
            $orden = Cliente::maximoPadreId();
        }
        $menu = Cliente::create([
            'nombre'    => $request->nombre,
            'slug'      => $request->slug,
            'icono'     => $request->icono,
            'padre_id'  => $request->padre_id ,
            'grupo_id'  => $request->grupo_id ,
            'orden'     => $orden
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cliente Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = Cliente::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdateClienteRequest $request)
    {
        $request->validated();

        $menu = Cliente::where('id',$request->id)->first();

        $menu->nombre           = $request->nombre;
        $menu->slug             = $request->slug;
        $menu->icono            = $request->icono;
        $menu->padre_id         = $request->padre_id;
        $menu->grupo_id         = $request->grupo_id;
        $menu->orden            = $request->orden;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cliente modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $menu = Cliente::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cliente eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $menus = Cliente::with([
            'usuario:id,name', 
            'agencia:id,nombre',
            'persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres'
        ])->get();
        return $menus;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion ?? 10; // Valor por defecto
    
        return Cliente::with([
                'usuario:id,name', 
                'agencia:id,nombre',
                'persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres'
            ])
            ->join('personas', 'clientes.persona_id', '=', 'personas.id')
            ->where(function ($query) use ($buscar) {
                $query->whereRaw('UPPER(personas.dni) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.ape_pat) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.ape_mat) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.primernombre) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.otrosnombres) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw("UPPER(CONCAT(personas.ape_pat, ' ', personas.ape_mat, ' ', personas.primernombre, ' ', IFNULL(personas.otrosnombres, ''))) LIKE ?", ['%' . $buscar . '%']);
            })
            ->select([
                'clientes.id',
                'clientes.usuario_id',
                'clientes.agencia_id',
                'clientes.persona_id',
                'clientes.estado',
                'clientes.fecha_reg',
                'clientes.hora_reg',
                DB::raw("CONCAT(personas.ape_pat, ' ', personas.ape_mat, ' ', personas.primernombre, ' ', IFNULL(personas.otrosnombres, '')) AS apenom")
            ])
            ->orderBy('apenom', 'asc') 
            ->paginate($paginacion);
    }
}
