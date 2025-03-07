<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ubicacion\StoreUbicacionRequest;
use App\Models\Distrito;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{

    public function store(StoreUbicacionRequest $request)
    {
        $domicilio = Ubicacion::create([
            'tipo'             => $request->tipodomicilio ?? 'NDF',
            'ubigeo'           => $request->ubigeodomicilio,
            'tipovia'          => $request->tipovia ?? 'S/N',
            'nombrevia'        => $request->nombrevia,
            'nro'              => $request->nro ?? 'S/N',
            'interior'         => $request->interior ?? 'S/N',
            'mz'               => $request->mz ?? 'S/N',
            'lote'             => $request->lote ?? 'S/N',
            'tipozona'         => $request->tipozona,
            'nombrezona'       => $request->nombrezona,
            'referencia'       => $request->referencia,
            'latitud_longitud' => $request->latitud_longitud,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente',
            'id'    => $domicilio->id,
            'direccion' => $domicilio->direccion,
        ],200);
    }

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
    public function destroy(Request $request)
    {
        $registro = Ubicacion::where('id', $request->id)->first();
        $registro->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }
}
