<?php

namespace App\Http\Controllers;

use App\Http\Requests\Credito\StoreCreditoRequest;
use App\Http\Requests\Credito\UpdateCreditoRequest;
use Illuminate\Support\Facades\DB;
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
        $credito = Credito::with([
            'cliente:id,estado,persona_id',
            'agencia:id,nombre',
            'asesor:id,name',
            'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres',
        ])->where('id', $request->id)->first();
        return $credito;
    }
    public function update(UpdateCreditoRequest $request)
    {
        $request->validated();
        $credito = Credito::where('id',$request->id)->first();
        $credito->cliente_id     = $request->cliente_id;
        $credito->agencia_id     = $request->agencia_id;
        $credito->asesor_id      = $request->asesor_id;
        $credito->estado         = $request->estado;
        $credito->fecha_reg      = $request->fecha_reg;
        $credito->tipo           = $request->tipo;
        $credito->monto          = $request->monto;
        $credito->producto       = $request->producto;
        $credito->frecuencia     = $request->frecuencia;
        $credito->plazo          = $request->plazo;
        $credito->medioorigen    = $request->medioorigen;
        $credito->dondepagara    = $request->dondepagara ?? 'NINGUNO';
        $credito->fuenterecursos = $request->fuenterecursos;
        $credito->tasainteres    = $request->tasainteres ?? 0.00;
        $credito->total          = $request->total ?? 0.00;
        $credito->costomora      = $request->costomora ?? 0.00;
        $credito->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Credito modificado satisfactoriamente'
        ],200);
    }
    public function obtenerTiposCreditoPorCiente(Request $request){

        $estados = Credito::where('cliente_id', $request->cliente_id)
        ->whereIn('estado', ['DESEMBOLSADO', 'FINALIZADO'])
        ->pluck('estado')
        ->toArray();
    
        if (in_array('DESEMBOLSADO', $estados)) {
            return response()->json(['Recurrente Con Saldo', 'Paralelo'], 200);
        }
        
        if (in_array('FINALIZADO', $estados)) {
            return response()->json(['Recurrente Sin Saldo'], 200);
        }
        
        return response()->json(['Nuevo'], 200);


    }
    public function destroy(Request $request)
    {
        $credito = Credito::where('id', $request->id)->first();
        $credito->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Credito eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $creditos = Credito::get();
        return $creditos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar ?? '');
        $paginacion = is_numeric($request->paginacion) ? $request->paginacion : 10; // Valor por defecto 10
    
        $query = Credito::with([
            'cliente:id,estado,persona_id',
            'agencia:id,nombre',
            'asesor:id,name',
            'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres',
        ]);
    
        if (!empty($buscar)) {
            $query->whereHas('cliente.persona', function ($q) use ($buscar) {
                $q->whereRaw("UPPER(dni) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(ape_pat) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(ape_mat) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(primernombre) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(otrosnombres) LIKE ?", ["%$buscar%"]);
            })->orwhere('id', $buscar);
        }
    
        return $query->paginate($paginacion);
    }
}
