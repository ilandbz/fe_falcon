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
use App\Models\Tesoreria;
use App\Http\Traits\DesembolsoTrait;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Barryvdh\DomPDF\Facade\Pdf;


class DesembolsoController extends Controller
{
    use DesembolsoTrait;
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
        Credito::where('id', $request->credito_id)->update(['estado' => 'DESEMBOLSADO']);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Desembolso Registrado satisfactoriamente'
        ],200);
    }
    
    public function procesarDesembolso(StoreDesembolsoRequest $request)
    {
        DB::beginTransaction(); // Iniciamos la transacción
    
        try {
            $desembolso = Desembolso::create([
                'credito_id'     => $request->credito_id,
                'fecha'          => $request->fecha,
                'hora'           => $request->hora,
                'user_id'        => $request->user_id,
                'descontado'     => $request->descontado,
                'totalentregado' => $request->totalentregado
            ]);
            Credito::where('id', $request->credito_id)->update(['estado' => 'DESEMBOLSADO']);
            $nro = Tesoreria::getNextNro($request->credito_id);
            Tesoreria::create([
                'tipo_entidad_id' => 1, // CAJA
                'agencia_id'      => $request->agencia_id,
                'nro'             => $nro, // Usamos el número obtenido sin modificar
                'fecha'           => $request->fecha,
                'hora'            => $request->hora,
                'tipo'            => 'SALIDA', // Es un desembolso (salida de dinero)
                'user_id'         => $request->user_id,
                'monto'           => $request->totalentregado,
                'saldo'           => 0, // Ajusta la lógica para calcular saldo si es necesario
                'descripcion'     => 'Desembolso crédito ID: ' . $request->credito_id.' Cliente: '.$request->apenom
            ]);
             if ($request->montoseguro > 0) { // Aseguramos que el monto del seguro sea válido
                Tesoreria::create([
                    'tipo_entidad_id' => 1, // CAJA
                    'agencia_id'      => $request->agencia_id,
                    'nro'             => $nro + 1, // Asignamos un número consecutivo SOLO si es necesario
                    'fecha'           => $request->fecha,
                    'hora'            => $request->hora,
                    'tipo'            => 'INGRESO', // Es un desembolso (salida de dinero)
                    'user_id'         => $request->user_id,
                    'monto'           => $request->montoseguro,
                    'saldo'           => 0, // Ajusta la lógica para calcular saldo si es necesario
                    'descripcion'     => 'Seguro crédito ID: ' . $request->credito_id.' Cliente: '.$request->apenom
                ]);
            }
            $this->generarCalendarioPagos($request);
            DB::commit();
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Desembolso y caja registrados correctamente'
            ], 200);
        } catch (QueryException $qe) {
            DB::rollBack(); // Revertimos cambios en caso de error de base de datos
            return response()->json([
                'ok' => 0,
                'error' => 'Error en la base de datos: ' . $qe->getMessage()
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack(); // Revertimos cambios en caso de error general
            return response()->json([
                'ok' => 0,
                'error' => 'Error al procesar el desembolso: ' . $e->getMessage()
            ], 500);
        }
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
        $estado = 'pago';
        $detalles = $desembolsos->map(function ($item) use (&$saldototal, &$estado) {
            $creditoPagar = $item->credito_pagar;
            $saldototal += $item->saldopagar;
            $estado = strtolower($item->estado) == 'debe' ? 'debe' : 'pago'; 
            return [
                "id" => $item->credito_pagar_id,
                "credito_id_pago" => $creditoPagar->credito_id,
                "Totalpagado" => $creditoPagar->Totalpagado,
                "Saldo" => $item->saldopagar,
                "Monto" => $creditoPagar->credito->monto,
                "Total" => $creditoPagar->credito->total,
                "Estado" => $creditoPagar->credito->estado,
                "estado_rcs"    => $item->estado,
            ];
        });
        // Calcular deuda total
        $deudatotal = $montoseguro + $montoconfioenti + $saldototal;
        return compact('deudatotal', 'montoseguro', 'montoconfioenti', 'saldototal', 'estado', 'detalles');        
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
<<<<<<< HEAD


    public function calendariopagosPDF(Request $request){
=======
    public function generarPDF(Request $request){
>>>>>>> 04ac818ffc4093815847df5be6b1f114c5038ad6
        $tipo = $request->tipo;
        $credito_id = $request->credito_id;
        if($tipo=='calendario'){
            $credito = Credito::with([
                'agencia:id,nombre,direccion,telefono',
                'asesor:id,name',
                'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,ubicacion_domicilio_id',
                'cliente.persona.ubicacion:id,tipo,ubigeo,tipovia,nombrevia,nro,interior,mz,lote,tipozona,nombrezona,referencia',
                'cliente.persona.ubicacion.distrito:id,ubigeo,nombre,provincia_id',
                'cliente.persona.ubicacion.distrito.provincia:id,nombre,departamento_id',
                'cliente.persona.ubicacion.distrito.provincia.departamento:id,nombre',
                'cliente.negocio:id,cliente_id,ubicacion_id',
                'desembolso:credito_id,fecha,totalentregado,descontado',
                'desembolso.detCalendarioPagos:credito_id,nrocuota,fecha_prog,nombredia,cuota,saldo',
            ])->where('id', $credito_id)->first();
            if($credito->cliente->negocio){	
                $data['domicilionegocio']=Ubicacion::where('id', $credito->cliente->negocio->idubicacion)->first();	
            }
    
    
    
            $data = [
                'credito'           => $credito,
                'cliente'           => $credito->cliente,
                'agencia'           => $credito->agencia,
                'asesor'            => $credito->asesor,
                'desembolso'        => $credito->desembolso,
                'cuotapagos'        => $credito->desembolso->detCalendarioPagos,
                'domicilio'         => $credito->cliente->persona->ubicacion,
    
            ];
        }




        $pdf = Pdf::loadView('pdfs/vistacalendario', $data)->setPaper('a4', 'landscape');;
        // return $pdf->stream('documento.pdf');
        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="calendario.pdf"',
        ]);

    }
}
