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
        //$request->validated();
        $pyg = VentaPG::create([
            'credito_id'       => $request->credito_id,
            'tot_ing_mensual'  => $request->tot_ing_mensual,
            'tot_cosprimo_m'   => $request->tot_cosprimo_m,
            'margen_tot'       => $request->margen_tot,
            'ventas_cred'      => $request->ventas_cred,
            'irrecuperable'    => $request->irrecuperable,
            'cantproductos'    => $request->cantproductos,
        ]);
        $detalles = $request->detalles;
        foreach($detalles as $row){
            DetVentaPG::create([
                'credito_id'        => $pyg->credito_id,
                'nroproducto'       => $row['nroproducto'],
                'descripcion'       => $row['descripcion'],
                'unidadmedida'      => $row['unidadmedida'],
                'preciounit'        => $row['preciounit'],
                'primaprincipal'    => $row['primaprincipal'],
                'primasecundaria'   => $row['primasecundaria'],
                'primacomplement'   => $row['primacomplement'],
                'matprima'          => $row['matprima'],
                'manoobra1'         => $row['manoobra1'],
                'manoobra2'         => $row['manoobra2'],
                'manoobra'          => $row['manoobra'],
                'costoprimount'     => $row['costoprimount'],
                'prodmensual'       => $row['prodmensual'],
                'ventastotales'     => $row['ventastotales'],
                'totcostoprimo'     => $row['totcostoprimo'],
                'margenventas'      => $row['margenventas'],
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
