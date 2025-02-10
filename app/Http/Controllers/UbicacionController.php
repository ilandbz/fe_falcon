<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function obtenerPorUbigeo(Request $request)
    {
        $registro = Distrito::with([
            'provincia:id,nombre,departamento_id',
            'provincia.departamento:id,nombre'])
            ->where('ubigeo', $request->ubigeo)
            ->first();
        return $registro;
    }
    public function listarDistritos(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        
        return Distrito::select(
            [
                'distritos.ubigeo as ubigeo',
                'distritos.nombre as distrito',
                'provincias.nombre as provincia',
                'departamentos.nombre as departamento'
            ])
            ->join('provincias', 'provincias.id', '=', 'distritos.provincia_id')
            ->join('departamentos', 'departamentos.id', '=', 'provincias.departamento_id')
            ->whereRaw('UPPER(distritos.nombre) LIKE ?', ['%' . $buscar . '%'])
            ->orWhereRaw('UPPER(provincias.nombre) LIKE ?', ['%' . $buscar . '%'])
            ->orWhereRaw('UPPER(departamentos.nombre) LIKE ?', ['%' . $buscar . '%'])
            ->paginate($paginacion);
    }
    
}
