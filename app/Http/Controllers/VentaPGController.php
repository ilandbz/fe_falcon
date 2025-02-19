<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerdidasGanancias\UpdatePerdidasGananciasRequest;
use App\Http\Requests\VentasPerdidasGanancias\StoreVentasPerdidasGananciasRequest;
use App\Models\DetVentaPG;
use App\Models\PerdidaGanancia;
use App\Models\VentaPG;
use Illuminate\Http\Request;

class VentaPGController extends Controller
{
    public function store(StoreVentasPerdidasGananciasRequest $request)
    {
        $request->validated();

        $pyg = VentaPG::create([
            'credito_id'       => $request->credito_id,
            'tot_ing_mensual'  => $request->tot_ing_mensual,
            'tot_cosprimo_m'   => $request->tot_cosprimo_m,
            'margen_tot'       => $request->margen_tot,
            'ventas_cred'      => $request->ventas_cred,
            'irrecuperable'    => $request->irrecuperable,
            'cantproductos'    => $request->cantproductos,
        ]);


        foreach ($request->detalles as $fila) {
            $fila = (array) $fila; // Asegura que es un array asociativo
            DetVentaPG::create([
                'credito_id'        => $pyg->credito_id,
                'nroproducto'       => $fila['nroproducto'] ?? null,
                'descripcion'       => $fila['descripcion'] ?? '',
                'unidadmedida'      => $fila['unidadmedida'] ?? '',
                'preciounit'        => $fila['preciounit'] ?? 0,
                'primaprincipal'    => $fila['primaprincipal'] ?? 0,
                'primasecundaria'   => $fila['primasecundaria'] ?? 0,
                'primacomplement'   => $fila['primacomplement'] ?? 0,
                'matprima'          => $fila['matprima'] ?? 0,
                'manoobra1'         => $fila['manoobra1'] ?? 0,
                'manoobra2'         => $fila['manoobra2'] ?? 0,
                'manoobra'          => $fila['manoobra'] ?? 0,
                'costoprimount'     => $fila['costoprimount'] ?? 0,
                'prodmensual'       => $fila['prodmensual'] ?? 0,
                'ventastotales'     => $fila['ventastotales'] ?? 0,
                'totcostoprimo'     => $fila['totcostoprimo'] ?? 0,
                'margenventas'      => $fila['margenventas'] ?? 0,
            ]);
        }
        
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Venta Registrado satisfactoriamente',
        ],200);
    }
    public function show(Request $request)
    {
        $pyg = VentaPG::with([
            'detalles',
        ])->where('credito_id', $request->credito_id)->first();
        return $pyg;
    }
    public function update(UpdatePerdidasGananciasRequest $request)
    {
        $request->validated();
        $pyg = VentaPG::where('credito_id',$request->credito_id)->first();
        $pyg->credito_id   = $request->credito_id;
        $pyg->tot_ing_mensual  = $request->tot_ing_mensual;
        $pyg->tot_cosprimo_m   = $request->tot_cosprimo_m;
        $pyg->margen_tot       = $request->margen_tot;
        $pyg->ventas_cred      = $request->ventas_cred;
        $pyg->irrecuperable    = $request->irrecuperable;
        $pyg->cantproductos    = $request->cantproductos;
        $pyg->save();

        foreach($request->detalles as $fila){
            DetVentaPG::firstOrCreate([
                'credito_id' => $request->credito_id,
                'nroproducto' => $request->nroproducto,
            ],[
                'descripcion'       => $fila['descripcion'],
                'unidadmedida'      => $fila['unidadmedida'],
                'preciounit'        => $fila['preciounit'],
                'primaprincipal'    => $fila['primaprincipal'],
                'primasecundaria'   => $fila['primasecundaria'],
                'primacomplement'   => $fila['primacomplement'],
                'matprima'          => $fila['matprima'],
                'manoobra1'         => $fila['manoobra1'],
                'manoobra2'         => $fila['manoobra2'],
                'manoobra'          => $fila['manoobra'],
                'costoprimount'     => $fila['costoprimount'],
                'prodmensual'       => $fila['prodmensual'],
                'ventastotales'     => $fila['ventastotales'],
                'totcostoprimo'     => $fila['totcostoprimo'],
                'margenventas'      => $fila['margenventas'],
            ]);
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Venta modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $pyg = PerdidaGanancia::where('id', $request->id)->first();
        $pyg->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Venta eliminado satisfactoriamente'
        ],200);
    }


}
