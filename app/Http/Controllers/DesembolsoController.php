<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelarCredito\StoreCancelarCreditoRequest;
use App\Http\Requests\Desembolso\StoreDesembolsoRequest;
use App\Http\Requests\Desembolso\UpdateDesembolsoRequest;
use App\Models\Credito;
use App\Models\CreditosCancelar;
use App\Models\Desembolso;
use App\Models\KardexCredito;
use App\Models\SeguroDesgravamen;
use Illuminate\Http\Request;

class DesembolsoController extends Controller
{
    public function store(StoreDesembolsoRequest $request)
    {

        $desembolso = Desembolso::create([
            'credito_id'     => $request->credito_id,
            'fecha'          => $request->fecha,
            'hora'           => $request->hora,
            'user_id'        => $request->user_id,
            'descontado'     => $request->descontado,
            'totalentregado' => $request->totalentregado
        ]);
        
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Desembolso Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = Desembolso::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdateDesembolsoRequest $request)
    {
        $desembolso = Desembolso::where('id', $request->id)->first();
        if ($desembolso) {
            $desembolso->credito_id     = $request->credito_id;
            $desembolso->fecha          = $request->fecha;
            $desembolso->hora           = $request->hora;
            $desembolso->user_id        = $request->user_id;
            $desembolso->descontado     = $request->descontado;
            $desembolso->totalentregado = $request->totalentregado;
            $desembolso->save();
        
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Desembolso actualizado correctamente'
            ], 200);
        } else {
            return response()->json([
                'ok' => 0,
                'mensaje' => 'Desembolso no encontrado'
            ], 404);
        }

    }

    public function destroy(Request $request)
    {
        $desembolso = Desembolso::where('id', $request->id)->first();
        $desembolso->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Desembolso eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Desembolso::with(['padre:id,nombre', 'grupo:id,titulo'])->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

    public function obtenerDescuentos(Request $request){
        $credito_id = $request->credito_id;
        $montosolicitado = $request->monto;
        $producto = $request->producto;
        // Obtener monto del seguro
        $montoseguro = SeguroDesgravamen::where('credito_id', $credito_id)->pluck('monto')->first() ?? 0;
        // Calcular monto "Confío en Ti"
        $montoconfioenti = ($producto === 'CONFIO EN TI') ? ($montosolicitado * 0.10) : 0;
        // Obtener desembolsos y calcular saldo total
        $desembolsos = CreditosCancelar::with([
            'credito_pagar:credito_id',//desembolso
            'credito_pagar.credito:id,monto,total,estado'//desembolso con su credito
        ])->where('credito_id', $credito_id)->get();
        $saldototal = 0;
        $detalles = $desembolsos->map(function ($item) use (&$saldototal) {
            $creditoPagar = $item->credito_pagar;
            $saldototal += $creditoPagar->Saldo;
            return [
                "id" => $item->credito_pagar_id,
                "credito_id_pago" => $creditoPagar->credito_id,
                "Totalpagado" => $creditoPagar->Totalpagado,
                "Saldo" => $creditoPagar->Saldo,
                "Monto" => $creditoPagar->credito->monto,
                "Total" => $creditoPagar->credito->total,
                "Estado" => $creditoPagar->credito->estado,
                "estado_rcs"    => $item->estado,
            ];
        });
        // Calcular deuda total
        $deudatotal = $montoseguro + $montoconfioenti + $saldototal;
        return compact('deudatotal', 'montoseguro', 'montoconfioenti', 'saldototal', 'detalles');        
    }
    public function cancelarCredito(StoreCancelarCreditoRequest $request){

        if($request->tipo_cancelar=='RCS'){  //debe ser incluido mora y otros
            $nro = KardexCredito::getNextNro($request->credito_id);
            $regkardex = KardexCredito::create([
                'credito_id' => $request->credito_id,
                'nro' =>$nro,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'montopagado' => $request->montopagado,
                'user_id' => $request->user_id,
                'mediopago' => $request->mediopago,
            ]);
            $credito = Credito::where('id', $request->credito_id)->first();
            $credito->estado = 'FINALIZADO';
            $credito->save(); 
            CreditosCancelar::where('credito_id', $request->credito_id_principal)->where('credito_pagar_id', $request->credito_id)->update(['estado' => 'PAGO']);
        }else{
            $nro = KardexCredito::getNextNro($request->credito_id);
            $regkardex = KardexCredito::create([
                'credito_id' => $request->credito_id,
                'nro' =>$nro,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'montopagado' => $request->montopagado,
                'user_id' => $request->user_id,
                'mediopago' => $request->mediopago,
            ]);
            $credito = Credito::where('id', $request->credito_id)->first();
            $credito->estado = 'FINALIZADO';
            $credito->save();            
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Credito Cancelado con Exito'
        ],200);
    }

}
