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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
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


    public function calendariopagosPDF(Request $request){
        $tipo = $request->tipo;
        $id = $request->credito_id;
        if($tipo=='solicitud'){
            $credito = Credito::with([
                'cliente:id,persona_id,estado',
                'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,genero,fecha_nac,nacionalidad,grado_instr,estado_civil,tipo_trabajador,ubicacion_domicilio_id',
                'asesor:id,dni,name',
                'asesor.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres',
                'cliente.persona.ubicacion:id,tipo,ubigeo,tipovia,nombrevia,nro,interior,mz,lote,tipozona,nombrezona,referencia',
                'cliente.persona.ubicacion.distrito:id,ubigeo,nombre,provincia_id',
                'cliente.persona.ubicacion.distrito.provincia:id,nombre,departamento_id',
                'cliente.persona.ubicacion.distrito.provincia.departamento:id,nombre',
                'cliente.negocio:id,cliente_id,razonsocial,ruc,tel_cel,tipo_actividad_id,descripcion,inicioactividad,ubicacion_id',
                'cliente.negocio.ubicacion:id,tipo,ubigeo,tipovia,nombrevia,nro,interior,mz,lote,tipozona,nombrezona,referencia',
                'cliente.negocio.ubicacion.distrito:id,ubigeo,nombre,provincia_id',
                'cliente.negocio.ubicacion.distrito.provincia:id,nombre,departamento_id',
                'cliente.negocio.ubicacion.distrito.provincia.departamento:id,nombre',
            ])
            ->where('id', $id)->first();

            $data = [
                'credito'           => $credito,
                'cliente'           => $credito->cliente,
                'domicilio'         => $credito->cliente->persona->ubicacion,
                'asesor'            => $credito->asesor,
                'negocio'           => $credito->cliente->negocio,
                'ubicacionnegocio'  =>  optional($credito->cliente->negocio)->ubicacion
            ];

            $pdf = Pdf::loadView('pdfs/solicitud', $data);
        }elseif($tipo=='Estados Financieros'){
            $credito = Credito::with([
                'cliente:id,persona_id,estado',
                'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,genero,fecha_nac,nacionalidad,grado_instr,estado_civil,tipo_trabajador,ubicacion_domicilio_id',
                'asesor.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres',
                'balance:credito_id,total_activo,total_pasivo,patrimonio,activocaja,activobancos,activoctascobrar,activoinventarios,pasivodeudaprove,pasivodeudaent,pasivodeudaempre,activomueble,activootrosact,activodepre,pasivolargop,otrascuentaspagar,totalacorriente,totalpcorriente,totalancorriente,totalpncorriente,fecha',
                'perdidas:credito_id,ventas,costo,utilidad,costonegocio,utiloperativa,otrosing,otrosegr,gast_fam,utilidadneta,utilnetdiaria',
                'perdidas.venta:credito_id,tot_ing_mensual,tot_cosprimo_m,margen_tot,ventas_cred,irrecuperable,cantproductos',
                'perdidas.venta.detalles',
                'perdidas.gastosnegocio:credito_id,alquiler,servicios,personal,sunat,transporte,gastosfinancieros,otros'
            ])
            ->where('id', $id)->first();
            $data = [
                'credito'           => $credito,
                'cliente'           => $credito->cliente,
                'balance'           => $credito->balance,
                'perdidasganancias' => $credito->perdidas,
                'ventaspyg'         => $credito->perdidas->venta,
                'gastosnegocios'    => $credito->gastosnegocio,

            ];
            $pdf = Pdf::loadView('pdfs/estadosfinancieros', $data);
        }elseif($tipo=='Analisis Cualitativo'){
            $credito = Credito::with([
                'cliente:id,persona_id,estado',
                'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,genero,fecha_nac,nacionalidad,grado_instr,estado_civil,tipo_trabajador,ubicacion_domicilio_id',
                'analisis:credito_id,tipogarantia,cargafamiliar,riesgoedadmax,antecedentescred,recorpagoult,niveldesarr,tiempo_neg,control_ingegre,vent_totdec,compsubsector,totunidfamiliar,totunidempresa,total'

            ])
            ->where('id', $id)->first();
            $data = [
                'analisiscualitativo'           => $credito->analisis,
            ];
            $pdf = Pdf::loadView('pdfs/analisis', $data);
        }elseif($tipo=='Seguro'){
            $credito = Credito::with([
                'cliente:id,persona_id,estado',
                'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,genero,fecha_nac,nacionalidad,grado_instr,estado_civil,tipo_trabajador,ubicacion_domicilio_id',
                'seguro:id,credito_id,monto'

            ])
            ->where('id', $id)->first();
            $data = [
                'cliente'           => $credito->cliente,
                'credito'           => $credito,
                'poliza'           => $credito->seguro,
            ];
            $pdf = Pdf::loadView('pdfs/seguro', $data);
        }elseif($tipo=='Propuesta'){
            $credito = Credito::with([
                'cliente:id,persona_id,estado',
                'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,genero,fecha_nac,nacionalidad,grado_instr,estado_civil,tipo_trabajador,ubicacion_domicilio_id',
                'propuesta:credito_id,unidad_familiar,experiencia_cred,destino_prest,referencias'

            ])
            ->where('id', $id)->first();
            $data = [
                'cliente'           => $credito->cliente,
                'credito'           => $credito,
            ];
            $pdf = Pdf::loadView('pdfs/propuestacredito', $data);
        }
        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="documento.pdf"',
        ]);

    }
}
