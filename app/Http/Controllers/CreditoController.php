<?php

namespace App\Http\Controllers;

use App\Http\Requests\Credito\StoreCreditoRequest;
use App\Http\Requests\Credito\UpdateCreditoRequest;
use App\Models\AnalisisCualitativo;
use App\Models\Balance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use App\Models\Credito;
use App\Models\CreditosCancelar;
use App\Models\PerdidaGanancia;
use App\Models\PropuestaCredito;
use App\Models\SeguroDesgravamen;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public function store(StoreCreditoRequest $request)
    {
        $monto = $request->monto;
        $credito = Credito::create([
            'cliente_id'    => $request->cliente_id,
            'agencia_id'    => $request->agencia_id,
            'asesor_id'     => $request->asesor_id,
            'estado'        => $request->estado,
            'fecha_reg'     => $request->fecha_reg,
            'tipo'          => $request->tipo,
            'monto'         => $monto,
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
		if ($monto < 1000) {
			$montopoliza = 2;
		} else {
			$montopoliza = floor($monto / 1000) * 2;
		}
        if($request->tipo==='Recurrente Con Saldo'){
            foreach ($request->creditos_seleccionados as $fila) {
                CreditosCancelar::create([
                    'credito_id'            => $credito->id,
                    'credito_pagar_id'      => $fila['id'],
                    'saldopagar'            => $fila['Saldo']
                ]);
            }
        }
        SeguroDesgravamen::Create([
            'credito_id'  => $credito->id,
            'monto'       => $montopoliza,
            'fecha_reg'   => now()->toDateString(),
            'hora_reg'    => now()->toTimeString(),
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Credito Registrado satisfactoriamente',
            'credito_id' => $credito->id,
        ],200);
    }
    public function show(Request $request)
    {
        $credito = Credito::with([
            'cliente:id,estado,persona_id',
            'agencia:id,nombre',
            'asesor:id,name',
            'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres',
            'cliente.creditos' => function ($query) {
                $query->where('estado', 'DESEMBOLSADO')->orwhere('estado', 'PAGAR POR RCS');
            }
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
    public function cambiarEstado(Request $request){
        Credito::where('id', $request->id)->update([
            'estado' => $request->estado,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Estado Actualizado'
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
                  ->orWhereRaw("UPPER(otrosnombres) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(CONCAT(personas.ape_pat, ' ', personas.ape_mat, ' ', personas.primernombre, ' ', IFNULL(personas.otrosnombres, ''))) LIKE ?", ['%' . $buscar . '%']);
                  ;
            })->orwhere('id', $buscar);
        }
    
        return $query->orderBy('fecha_reg', 'Desc')->paginate($paginacion);
    }
    public function listarCreditosPorEstado(Request $request){
        $estado =$request->estado;
        $agencia_id=$request->agencia_id;

        $buscar = mb_strtoupper($request->buscar ?? '');
        $paginacion = is_numeric($request->paginacion) ? $request->paginacion : 10; // Valor por defecto 10
    
        $query = Credito::with([
            'cliente:id,estado,persona_id',
            'agencia:id,nombre',
            'asesor:id,name',
            'cliente.persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres',
        ])->where('estado', $estado);
        if (!empty($buscar)) {
            $query->whereHas('cliente.persona', function ($q) use ($buscar) {
                $q->whereRaw("UPPER(dni) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(ape_pat) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(ape_mat) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(primernombre) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(otrosnombres) LIKE ?", ["%$buscar%"])
                  ->orWhereRaw("UPPER(CONCAT(personas.ape_pat, ' ', personas.ape_mat, ' ', personas.primernombre, ' ', IFNULL(personas.otrosnombres, ''))) LIKE ?", ['%' . $buscar . '%']);
                  ;
            })->orwhere('id', $buscar);
        }
        if (!empty($agencia_id)) {
            $query->where('agencia_id', $agencia_id);
        }
    
        return $query->orderBy('fecha_reg', 'Desc')->paginate($paginacion);
    }
    public function cargarEvaluacionAnterior(Request $request)
    {
        $credito_id = $request->credito_id;
        $cliente_id = $request->cliente_id;
    
        // Buscar el crédito anterior
        $credito = Credito::with(['analisis', 'balance', 'perdidas', 'propuesta'])
            ->where('cliente_id', $cliente_id)
            ->where('estado', '!=', 'Registrado')
            ->first();
    
        // Verificar si se encontró un crédito válido
        if (!$credito) {
            return response()->json(['error' => 'No se encontró un crédito válido'], 404);
        }
    
        // Modelos relacionados a duplicar
        $relaciones = [
            'analisis' => AnalisisCualitativo::class,
            'balance' => Balance::class,
            'perdidas' => PerdidaGanancia::class,
            'propuesta' => PropuestaCredito::class,
        ];
    
        foreach ($relaciones as $relacion => $modelo) {
            if ($credito->$relacion) { // Verifica si la relación existe
                $modelo::where('credito_id', $credito_id)->delete();
                $nuevoRegistro = $credito->$relacion->replicate();
                $nuevoRegistro->credito_id = $credito_id;
                $nuevoRegistro->save();
            }
        }

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Evaluación anterior copiada correctamente',
        ],200);
    }
    public function validarParaEvaluacion(Request $request){
        $solicitud = Credito::with(['analisis', 'balance', 'perdidas', 'propuesta'])
        ->where('id', $request->id)->first();
        if (!$solicitud) {
            return response()->json([
                'ok' => 0,
                'mensaje' => 'Solicitud no encontrada',
            ], 404);
        }
        if($solicitud->tieneTodosLosRegistros()){
            $rsta=1;
        }else{
            $rsta=0;
        }
        return response()->json([
            'ok' => $rsta,
            'mensaje' => 'Validacion Realizada',
        ],200);
    }
    public function generarPDF(Request $request){
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
