<?php
namespace App\Http\Traits;

use App\Models\Atencion;
use App\Models\Establecimiento;
use App\Models\Marcacion;
use App\Models\MinsaInsumo;
use App\Models\MinsaMedicamento;
use App\Models\MinsaProcedimiento;
use App\Models\MinsaServicio;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ReportesTrait
{
    public static function produccionByAtencion(Request $request){
        set_time_limit(60);
        $anhoMes = $request->anho . $request->mes;
        $paginacion = $request->paginacion;
        $tipo = $request->tipo;
        $resultado = Atencion::select(
            DB::raw("concat(atencions.codigo,'-',atencions.lote,'-',atencions.numero) as fua"),
            'atencions.codigo',
            'lote',
            'numero',
            DB::raw("concat(pacientes.ape_paterno, ' ', pacientes.ape_materno, ' ',pacientes.primer_nombre, ' ',pacientes.otros_nombres) as paciente"),
            'fecha_atencion',
            'fecha_alta',
            'idusuariotrans',
            'costo_total',
            DB::raw('usuario_trans.user_login as user'),
            DB::raw('count(atencion_diagnosticos.id) as diagnosticos'),
        )
        ->addSelect(DB::raw('COALESCE(SUM(subtotal), 0) AS medicamentos'))
        ->addSelect(DB::raw('COALESCE(SUM(subtotal_insumo), 0) AS insumos'))
        ->addSelect(DB::raw('COALESCE(SUM(subtotal_procedimiento), 0) AS procedimientos'))
        ->addSelect(DB::raw('(COALESCE(SUM(subtotal), 0) + COALESCE(SUM(subtotal_insumo), 0) + COALESCE(SUM(subtotal_procedimiento), 0)) AS subtotal'))
        ->join('atencion_diagnosticos', 'atencions.id', '=', 'atencion_diagnosticos.atencion_id')
        ->leftJoinSub(
            function ($join) use ($anhoMes) {
                $join->select(
                        'atencion_diagnostico_id',
                        DB::raw('SUM(COALESCE(cantidad_entregada, 0) * COALESCE(PREOPE, 0)) AS subtotal')
                    )
                    ->from('atencion_medicamentos')
                    ->leftJoin('precio_medicamentos', function ($join) use ($anhoMes) {
                        $join->on('atencion_medicamentos.medicamento_id', '=', 'precio_medicamentos.medicamento_id')
                            ->where('precio_medicamentos.CPERIODO', '=', $anhoMes);
                    })
                    ->groupBy('atencion_diagnostico_id');
            },
            'medicamentos_subtotal',
            'atencion_diagnosticos.id',
            '=',
            'medicamentos_subtotal.atencion_diagnostico_id'
        )
        ->leftJoinSub(
            function ($join) use ($anhoMes) {
                $join->select(
                        'atencion_diagnostico_id',
                        DB::raw('SUM(COALESCE(cantidad_entregada, 0) * COALESCE(PREOPE, 0)) AS subtotal_insumo')
                    )
                    ->from('atencion_insumos')
                    ->leftJoin('precio_insumos', function ($join) use ($anhoMes) {
                        $join->on('atencion_insumos.insumo_id', '=', 'precio_insumos.insumo_id')
                            ->where('precio_insumos.CPERIODO', '=', $anhoMes);
                    })
                    ->groupBy('atencion_diagnostico_id');
            },
            'insumos_subtotal',
            'atencion_diagnosticos.id',
            '=',
            'insumos_subtotal.atencion_diagnostico_id'
        )
        ->leftJoinSub(
            function ($join) use ($anhoMes) {
                $join->select(
                        'atencion_diagnostico_id',
                        DB::raw('SUM(COALESCE(apro_CantEjecutado, 0) * COALESCE(nivel2, 0)) AS subtotal_procedimiento')
                    )
                    ->from('atencion_procedimientos')
                    ->leftJoin('precio_procedimientos', function ($join) use ($anhoMes) {
                        $join->on('atencion_procedimientos.procedimiento_id', '=', 'precio_procedimientos.procedimiento_id');
                    })
                    ->groupBy('atencion_diagnostico_id');
            },
            'procedimientos_subtotal',
            'atencion_diagnosticos.id',
            '=',
            'procedimientos_subtotal.atencion_diagnostico_id'
        )
        ->join('pacientes', 'atencions.paciente_id', '=', 'pacientes.id')
        ->leftjoin('usuario_trans', 'atencions.usuario_tran_id', '=', 'usuario_trans.id')
        ->whereYear('atencions.fecha_atencion', '=', $request->anho)
        ->whereMonth('atencions.fecha_atencion', '=', $request->mes)
        ->orderBy('pacientes.ape_paterno', 'asc')
        ->groupBy('atencions.id');
        if ($tipo == 'full') {
            $resultado = $resultado->get();
        } else {
            $resultado = $resultado->paginate($paginacion);
        }
        return $resultado;
    }

    public static function totalProduccionAtencionPorMes(Request  $request)
    {
        set_time_limit(60);
        $anhoMes = $request->anho . $request->mes;
        $resultado = Atencion::select(
            DB::Raw("month(atencions.fecha_atencion) as mes"),
            DB::raw('COALESCE(SUM(subtotal), 0) AS total_medicamentos'),
            DB::raw('COALESCE(SUM(subtotal_insumo), 0) AS total_insumos'),
            DB::raw('COALESCE(SUM(subtotal_procedimiento), 0) AS total_procedimientos'),
            DB::raw('(COALESCE(SUM(subtotal), 0) + COALESCE(SUM(subtotal_insumo), 0) + COALESCE(SUM(subtotal_procedimiento), 0)) AS subtotal')
        )
        ->join('atencion_diagnosticos', 'atencions.id', '=', 'atencion_diagnosticos.atencion_id')
        ->leftJoinSub(
            function ($join) use ($anhoMes) {
                $join->select(
                        'atencion_diagnostico_id',
                        DB::raw('SUM(COALESCE(cantidad_entregada, 0) * COALESCE(PREOPE, 0)) AS subtotal')
                    )
                    ->from('atencion_medicamentos')
                    ->leftJoin('precio_medicamentos', function ($join) use ($anhoMes) {
                        $join->on('atencion_medicamentos.medicamento_id', '=', 'precio_medicamentos.medicamento_id');
                    })
                    ->groupBy('atencion_diagnostico_id');
            },
            'medicamentos_subtotal',
            'atencion_diagnosticos.id',
            '=',
            'medicamentos_subtotal.atencion_diagnostico_id'
        )
        ->leftJoinSub(
            function ($join) use ($anhoMes) {
                $join->select(
                        'atencion_diagnostico_id',
                        DB::raw('SUM(COALESCE(cantidad_entregada, 0) * COALESCE(PREOPE, 0)) AS subtotal_insumo')
                    )
                    ->from('atencion_insumos')
                    ->leftJoin('precio_insumos', function ($join) use ($anhoMes) {
                        $join->on('atencion_insumos.insumo_id', '=', 'precio_insumos.insumo_id');
                    })
                    ->groupBy('atencion_diagnostico_id');
            },
            'insumos_subtotal',
            'atencion_diagnosticos.id',
            '=',
            'insumos_subtotal.atencion_diagnostico_id'
        )
        ->leftJoinSub(
            function ($join) use ($anhoMes) {
                $join->select(
                        'atencion_diagnostico_id',
                        DB::raw('SUM(COALESCE(apro_CantEjecutado, 0) * COALESCE(nivel2, 0)) AS subtotal_procedimiento')
                    )
                    ->from('atencion_procedimientos')
                    ->leftJoin('precio_procedimientos', function ($join) use ($anhoMes) {
                        $join->on('atencion_procedimientos.procedimiento_id', '=', 'precio_procedimientos.procedimiento_id');
                    })
                    ->groupBy('atencion_diagnostico_id');
            },
            'procedimientos_subtotal',
            'atencion_diagnosticos.id',
            '=',
            'procedimientos_subtotal.atencion_diagnostico_id'
        )
        ->join('pacientes', 'atencions.paciente_id', '=', 'pacientes.id')
        ->leftjoin('usuario_trans', 'atencions.usuario_tran_id', '=', 'usuario_trans.id')
        ->whereYear('atencions.fecha_atencion', '=', $request->anho)
        ->orderBy( DB::Raw("month(atencions.fecha_atencion)"), 'asc')
        ->groupBy(
            DB::Raw("month(atencions.fecha_atencion)")
        )
        ->get()
        ;
        $data = [['produccion', 'Insumos', 'Medicamentos', 'CPT']];
        foreach ($resultado as $item) {
            $mesNombre = strftime('%B', mktime(0, 0, 0, $item->mes, 1, 2000));
            $totalInsumos = floatval($item->total_insumos);
            $totalMedicamentos = floatval($item->total_medicamentos);
            $totalProcedimientos = floatval($item->total_procedimientos);
            $data[] = [$mesNombre, $totalInsumos, $totalMedicamentos, $totalProcedimientos];
        }
        return response()->json($data);
    }

    public static function medicamentosMinsa(Request $request){
        $paginacion = $request->paginacion;
        $resultado = MinsaMedicamento::select(
                'minsa_medicamentos.fua',
                'minsa_medicamentos.lote',
                'minsa_medicamentos.numero',
                'pacientes.nro_documento',
                DB::raw("CONCAT(pacientes.ape_paterno,' ',pacientes.ape_materno, ', ', pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom"),
                'medicamentos.med_CodMed as codigo',
                'medicamentos.med_Nombre as descripcion',
                'minsa_medicamentos.cantidad',
                'minsa_medicamentos.precio_aplicado as precio',
                'minsa_medicamentos.total',
                'minsa_medicamentos.estado'
            )
            ->leftJoin('pacientes', 'minsa_medicamentos.paciente_id', '=', 'pacientes.id')
            ->leftJoin('medicamentos', 'minsa_medicamentos.medicamento_id', '=', 'medicamentos.id')
            ->where('minsa_medicamentos.periodo', $request->codigo)
            ->orderBy('pacientes.ape_paterno', 'asc');
        if ($request->tipo == 'full') {
            $resultado = $resultado->get();
        } else {
            $resultado = $resultado->paginate($paginacion);
        }
        return $resultado;
    }
    public static function insumosMinsa(Request $request){
        $paginacion = $request->paginacion;
        $resultado = MinsaInsumo::select(
                'minsa_insumos.fua',
                'minsa_insumos.lote',
                'minsa_insumos.numero',
                'pacientes.nro_documento',
                DB::raw("CONCAT(pacientes.ape_paterno,' ',pacientes.ape_materno, ', ', pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom"),
                'insumos.ins_CodIns as codigo',
                'insumos.ins_Nombre as descripcion',
                'minsa_insumos.cantidad',
                'minsa_insumos.precio_aplicado as precio',
                'minsa_insumos.total',
                'minsa_insumos.estado'
            )
            ->leftJoin('pacientes', 'minsa_insumos.paciente_id', '=', 'pacientes.id')
            ->leftJoin('insumos', 'minsa_insumos.insumo_id', '=', 'insumos.id')
            ->where('minsa_insumos.periodo', $request->codigo)
            ->orderBy('pacientes.ape_paterno', 'asc');
        if ($request->tipo == 'full') {
            $resultado = $resultado->get();
        } else {
            $resultado = $resultado->paginate($paginacion);
        }
        return $resultado;
    }
    public static function procedimientosMinsa(Request $request){
        $paginacion = $request->paginacion;
        $resultado = MinsaProcedimiento::select(
                'minsa_procedimientos.fua',
                'minsa_procedimientos.lote',
                'minsa_procedimientos.numero',
                'pacientes.nro_documento',
                DB::raw("CONCAT(pacientes.ape_paterno,' ',pacientes.ape_materno, ', ', pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom"),
                'procedimientos.PRCD_V_CODPRO_MINSA as codigo',
                'procedimientos.PRCD_V_DESPROCEDIMIENTO as descripcion',
                'minsa_procedimientos.cantidad',
                'minsa_procedimientos.precio_aplicado as precio',
                'minsa_procedimientos.total',
                'minsa_procedimientos.estado'
            )
            ->leftJoin('pacientes', 'minsa_procedimientos.paciente_id', '=', 'pacientes.id')
            ->leftJoin('procedimientos', 'minsa_procedimientos.procedimiento_id', '=', 'procedimientos.id')
            ->where('minsa_procedimientos.periodo', $request->codigo)
            ->orderBy('pacientes.ape_paterno', 'asc');
        if ($request->tipo == 'full') {
            $resultado = $resultado->get();
        } else {
            $resultado = $resultado->paginate($paginacion);
        }
        return $resultado;
    }
    public static function serviciosMinsa(Request $request){
        $paginacion = $request->paginacion;
        $resultado = MinsaServicio::select(
                'minsa_servicios.fua',
                'minsa_servicios.lote',
                'minsa_servicios.numero',
                'pacientes.nro_documento',
                DB::raw("CONCAT(pacientes.ape_paterno,' ',pacientes.ape_materno, ', ', pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom"),
                'servicios.codigo as codigo',
                'servicios.descripcion as descripcion',
                'minsa_servicios.valorNetoServ',
                'minsa_servicios.valorBrutoServ',
                'minsa_servicios.ate_fecate',
                'minsa_servicios.ate_fecing as fecha_digitado',
                'minsa_servicios.estado'
            )
            ->leftJoin('pacientes', 'minsa_servicios.paciente_id', '=', 'pacientes.id')
            ->leftJoin('servicios', 'minsa_servicios.servicio_id', '=', 'servicios.id')
            ->where('minsa_servicios.periodo', $request->codigo)
            ->orderBy('pacientes.ape_paterno', 'asc');
        if ($request->tipo == 'full') {
            $resultado = $resultado->get();
        } else {
            $resultado = $resultado->paginate($paginacion);
        }
        return $resultado;
    }


    public static function RporteBrutoNeto(Request $request)
    {
        set_time_limit(60);
        $anho = $request->anho;
        $producto = $request->producto;
        $paginacion = $request->paginacion;
        $estado = $request->estado;
        if($producto=='Insumo'){
            
            $resultado = DB::table('minsa_insumos')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY minsa_insumos.periodo) AS ITEM'),
                DB::raw('COUNT(DISTINCT minsa_insumos.fua) as CANTIDAD'),
                DB::raw('SUM(arfsis.cantidad_preescrita * minsa_insumos.precio_aplicado) as BRUTO'),
                DB::raw('SUM(minsa_insumos.total) as NETO'),
                DB::raw('ABS(IFNULL(SUM(arfsis.cantidad_preescrita * minsa_insumos.precio_aplicado), 0) - SUM(minsa_insumos.total)) as DIFERENCIA'),
                'minsa_insumos.periodo as PERIODO'
            )
            ->leftJoin(
                DB::raw(
                    '(SELECT
                        atencion_insumos.insumo_id,
                        periodos.codigo as periodo,
                        atencions.numero,
                        atencions.lote,
                        atencion_insumos.cantidad_preescrita as cantidad_preescrita
                    FROM atencion_insumos
                    JOIN atencion_diagnosticos ON atencion_insumos.atencion_diagnostico_id = atencion_diagnosticos.id
                    JOIN atencions ON atencion_diagnosticos.atencion_id = atencions.id
                    JOIN periodos ON atencions.periodo_id = periodos.id
                    GROUP BY
                        atencion_insumos.insumo_id,
                        periodos.codigo,
                        atencions.numero,
                        atencions.lote,
                        atencion_insumos.cantidad_preescrita
                    ) as arfsis'
                ),
                function ($join) {
                    $join->on('minsa_insumos.insumo_id', '=', 'arfsis.insumo_id')
                        ->on('minsa_insumos.periodo', '=', 'arfsis.periodo')
                        ->on('minsa_insumos.lote', '=', 'arfsis.lote')
                        ->on('minsa_insumos.numero', '=', 'arfsis.numero');
                }
            )
            ->where('minsa_insumos.estado', 0)
            ->where('minsa_insumos.periodo', 'LIKE', $anho.'%')
            ->groupBy('minsa_insumos.periodo');


            $registros = DB::table('minsa_insumos')
            ->select(
                'minsa_insumos.fua',
                'arfsis.codigo',
                DB::raw('COUNT(minsa_insumos.insumo_id) as registros'),
                DB::raw('SUM(IFNULL(arfsis.cantidad_preescrita * minsa_insumos.precio_aplicado, 0)) as bruto'),
                DB::raw('SUM(minsa_insumos.total) as neto'),
                DB::raw('ABS(SUM(IFNULL(arfsis.cantidad_preescrita * minsa_insumos.precio_aplicado, 0)) - SUM(minsa_insumos.total)) as diferencia'),
                'minsa_insumos.periodo',
                'arfsis.user_login',
                'pacientes.nro_documento as dni',
                DB::raw("concat(pacientes.ape_paterno, ' ',pacientes.ape_materno, ', ',pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom")
            )
            ->leftJoin('pacientes', 'minsa_insumos.paciente_id', '=', 'pacientes.id')
            ->leftJoin(
                DB::raw(
                    "(SELECT
                        atencion_insumos.insumo_id,
                        atencions.codigo,
                        periodos.codigo as periodo,
                        usuario_trans.user_login,
                        atencions.numero,
                        atencions.lote,
                        atencion_insumos.cantidad_preescrita as cantidad_preescrita,
                        atencion_insumos.cantidad_entregada as cantidad_entregada
                    FROM atencion_insumos
                    JOIN atencion_diagnosticos ON atencion_insumos.atencion_diagnostico_id = atencion_diagnosticos.id
                    JOIN atencions ON atencion_diagnosticos.atencion_id = atencions.id
                    JOIN periodos ON atencions.periodo_id = periodos.id
                    JOIN usuario_trans ON atencions.usuario_tran_id = usuario_trans.id
                    GROUP BY
                        atencion_insumos.insumo_id,
                        periodos.codigo,
                        atencions.numero,
                        atencions.lote,
                        atencion_insumos.cantidad_preescrita,
                        atencions.codigo,
                        usuario_trans.user_login,
                        atencion_insumos.cantidad_entregada
                    ) as arfsis"
                ),
                function ($join) {
                    $join->on('minsa_insumos.insumo_id', '=', 'arfsis.insumo_id')
                        ->on('minsa_insumos.periodo', '=', 'arfsis.periodo')
                        ->on('minsa_insumos.lote', '=', 'arfsis.lote')
                        ->on('minsa_insumos.numero', '=', 'arfsis.numero');
                }
            )
            ->where('minsa_insumos.periodo', 'LIKE', '2023%')
            ->groupBy('minsa_insumos.fua', 'arfsis.codigo', 'minsa_insumos.periodo', 'arfsis.user_login', 'pacientes.nro_documento',
            DB::raw("concat(pacientes.ape_paterno, ' ',pacientes.ape_materno, ', ',pacientes.primer_nombre, ' ',pacientes.otros_nombres)")
        );

        }elseif($producto=='Medicamento'){
            $resultado = DB::table('minsa_medicamentos')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY minsa_medicamentos.periodo) AS ITEM'),
                DB::raw('COUNT(DISTINCT minsa_medicamentos.fua) as CANTIDAD'),
                DB::raw('SUM(arfsis.cantidad_preescrita * minsa_medicamentos.precio_aplicado) as BRUTO'),
                DB::raw('SUM(minsa_medicamentos.total) as NETO'),
                DB::raw('ABS(IFNULL(SUM(arfsis.cantidad_preescrita * minsa_medicamentos.precio_aplicado), 0) - SUM(minsa_medicamentos.total)) as DIFERENCIA'),
                'minsa_medicamentos.periodo as PERIODO'
            )
            ->leftJoin(
                DB::raw(
                    '(SELECT
                        atencion_medicamentos.medicamento_id,
                        periodos.codigo as periodo,
                        atencions.numero,
                        atencions.lote,
                        atencion_medicamentos.cantidad_preescrita as cantidad_preescrita
                    FROM atencion_medicamentos
                    JOIN atencion_diagnosticos ON atencion_medicamentos.atencion_diagnostico_id = atencion_diagnosticos.id
                    JOIN atencions ON atencion_diagnosticos.atencion_id = atencions.id
                    JOIN periodos ON atencions.periodo_id = periodos.id
                    GROUP BY
                        atencion_medicamentos.medicamento_id,
                        periodos.codigo,
                        atencions.numero,
                        atencions.lote,
                        atencion_medicamentos.cantidad_preescrita
                    ) as arfsis'
                ),
                function ($join) {
                    $join->on('minsa_medicamentos.medicamento_id', '=', 'arfsis.medicamento_id')
                        ->on('minsa_medicamentos.periodo', '=', 'arfsis.periodo')
                        ->on('minsa_medicamentos.lote', '=', 'arfsis.lote')
                        ->on('minsa_medicamentos.numero', '=', 'arfsis.numero');
                }
            )
            ->where('minsa_medicamentos.estado', 0)
            ->where('minsa_medicamentos.periodo', 'LIKE', $anho.'%')
            ->groupBy('minsa_medicamentos.periodo');
        
            $registros = DB::table('minsa_medicamentos')
            ->select(
                'minsa_medicamentos.fua',
                'arfsis.codigo',
                'arfsis.dni',
                'arfsis.apenom',
                DB::raw('COUNT(minsa_medicamentos.medicamento_id) as registros'),
                DB::raw('SUM(IFNULL(arfsis.cantidad_preescrita * minsa_medicamentos.precio_aplicado, 0)) as bruto'),
                DB::raw('SUM(minsa_medicamentos.total) as neto'),
                DB::raw('ABS(SUM(IFNULL(arfsis.cantidad_preescrita * minsa_medicamentos.precio_aplicado, 0)) - SUM(minsa_medicamentos.total)) as diferencia'),
                'minsa_medicamentos.periodo',
                'arfsis.user_login'
            )
            ->leftJoin('pacientes', 'minsa_medicamentos.paciente_id', '=', 'pacientes.id')
            ->leftJoin(
                DB::raw(
                    "(SELECT
                        atencion_medicamentos.medicamento_id,
                        atencions.codigo,
                        periodos.codigo as periodo,
                        usuario_trans.user_login,
                        atencions.numero,
                        atencions.lote,
                        atencion_medicamentos.cantidad_preescrita as cantidad_preescrita,
                        atencion_medicamentos.cantidad_entregada as cantidad_entregada,
                        pacientes.nro_documento as dni,
                        concat(pacientes.ape_paterno, ' ',pacientes.ape_materno, ', ',pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom
                    FROM atencion_medicamentos
                    JOIN atencion_diagnosticos ON atencion_medicamentos.atencion_diagnostico_id = atencion_diagnosticos.id
                    JOIN atencions ON atencion_diagnosticos.atencion_id = atencions.id
                    JOIN periodos ON atencions.periodo_id = periodos.id
                    JOIN usuario_trans ON atencions.usuario_tran_id = usuario_trans.id
                    left join pacientes on atencions.paciente_id=pacientes.id
                    GROUP BY
                        atencion_medicamentos.medicamento_id,
                        periodos.codigo,
                        atencions.numero,
                        atencions.lote,
                        atencion_medicamentos.cantidad_preescrita,
                        atencions.codigo,
                        usuario_trans.user_login,
                        atencion_medicamentos.cantidad_entregada,
                        pacientes.nro_documento,
                        concat(pacientes.ape_paterno, ' ',pacientes.ape_materno, ', ',pacientes.primer_nombre, ' ',pacientes.otros_nombres)
                    ) as arfsis"
                ),
                function ($join) {
                    $join->on('minsa_medicamentos.medicamento_id', '=', 'arfsis.medicamento_id')
                        ->on('minsa_medicamentos.periodo', '=', 'arfsis.periodo')
                        ->on('minsa_medicamentos.lote', '=', 'arfsis.lote')
                        ->on('minsa_medicamentos.numero', '=', 'arfsis.numero');
                }
            )
            ->where('minsa_medicamentos.periodo', 'LIKE', $anho.'%')
            ->groupBy('minsa_medicamentos.fua', 'arfsis.codigo', 'minsa_medicamentos.periodo', 'arfsis.user_login','arfsis.dni', 'arfsis.apenom');
        

        }else{
            $resultado = DB::table('minsa_procedimientos')
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY minsa_procedimientos.periodo) AS ITEM'),
                DB::raw('COUNT(DISTINCT minsa_procedimientos.fua) as CANTIDAD'),
                DB::raw('SUM(arfsis.cantidad_preescrita * minsa_procedimientos.precio_aplicado) as BRUTO'),
                DB::raw('SUM(minsa_procedimientos.total) as NETO'),
                DB::raw('ABS(IFNULL(SUM(arfsis.cantidad_preescrita * minsa_procedimientos.precio_aplicado), 0) - SUM(minsa_procedimientos.total)) as DIFERENCIA'),
                'minsa_procedimientos.periodo as PERIODO'
            )
            ->leftJoin(
                DB::raw(
                    '(SELECT
                        atencion_procedimientos.procedimiento_id,
                        periodos.codigo as periodo,
                        atencions.numero,
                        atencions.lote,
                        atencion_procedimientos.apro_CantIndicado as cantidad_preescrita
                    FROM atencion_procedimientos
                    JOIN atencion_diagnosticos ON atencion_procedimientos.atencion_diagnostico_id = atencion_diagnosticos.id
                    JOIN atencions ON atencion_diagnosticos.atencion_id = atencions.id
                    JOIN periodos ON atencions.periodo_id = periodos.id
                    GROUP BY
                        atencion_procedimientos.procedimiento_id,
                        periodos.codigo,
                        atencions.numero,
                        atencions.lote,
                        atencion_procedimientos.apro_CantIndicado
                    ) as arfsis'
                ),
                function ($join) {
                    $join->on('minsa_procedimientos.procedimiento_id', '=', 'arfsis.procedimiento_id')
                        ->on('minsa_procedimientos.periodo', '=', 'arfsis.periodo')
                        ->on('minsa_procedimientos.lote', '=', 'arfsis.lote')
                        ->on('minsa_procedimientos.numero', '=', 'arfsis.numero');
                }
            )
            ->where('minsa_procedimientos.estado', 0)
            ->where('minsa_procedimientos.periodo', 'LIKE', $anho.'%')
            ->groupBy('minsa_procedimientos.periodo');

            $registros = DB::table('minsa_procedimientos')
            ->select(
                'minsa_procedimientos.fua',
                'arfsis.codigo',
                'arfsis.dni',
                'arfsis.apenom',
                DB::raw('COUNT(minsa_procedimientos.procedimiento_id) as registros'),
                DB::raw('SUM(IFNULL(arfsis.cantidad_preescrita * minsa_procedimientos.precio_aplicado, 0)) as bruto'),
                DB::raw('SUM(minsa_procedimientos.total) as neto'),
                DB::raw('ABS(SUM(IFNULL(arfsis.cantidad_preescrita * minsa_procedimientos.precio_aplicado, 0)) - SUM(minsa_procedimientos.total)) as diferencia'),
                'minsa_procedimientos.periodo',
                'arfsis.user_login'
            )
            ->leftJoin('pacientes', 'minsa_procedimientos.paciente_id', '=', 'pacientes.id')
            ->leftJoin(
                DB::raw(
                    "(SELECT
                        atencion_procedimientos.procedimiento_id,
                        atencions.codigo,
                        periodos.codigo as periodo,
                        usuario_trans.user_login,
                        atencions.numero,
                        atencions.lote,
                        atencion_procedimientos.apro_CantIndicado as cantidad_preescrita,
                        atencion_procedimientos.apro_CantEjecutado as cantidad_entregada,
                        pacientes.nro_documento as dni,
                        concat(pacientes.ape_paterno, ' ',pacientes.ape_materno, ', ',pacientes.primer_nombre, ' ',pacientes.otros_nombres) as apenom
                    FROM atencion_procedimientos
                    JOIN atencion_diagnosticos ON atencion_procedimientos.atencion_diagnostico_id = atencion_diagnosticos.id
                    JOIN atencions ON atencion_diagnosticos.atencion_id = atencions.id
                    JOIN periodos ON atencions.periodo_id = periodos.id
                    JOIN usuario_trans ON atencions.usuario_tran_id = usuario_trans.id
                    left join pacientes on atencions.paciente_id=pacientes.id
                    GROUP BY
                        atencion_procedimientos.procedimiento_id,
                        periodos.codigo,
                        atencions.numero,
                        atencions.lote,
                        atencion_procedimientos.apro_CantIndicado,
                        atencions.codigo,
                        usuario_trans.user_login,
                        atencion_procedimientos.apro_CantEjecutado,
                        pacientes.nro_documento,
                        concat(pacientes.ape_paterno, ' ',pacientes.ape_materno, ', ',pacientes.primer_nombre, ' ',pacientes.otros_nombres)
                    ) as arfsis"
                ),
                function ($join) {
                    $join->on('minsa_procedimientos.procedimiento_id', '=', 'arfsis.procedimiento_id')
                        ->on('minsa_procedimientos.periodo', '=', 'arfsis.periodo')
                        ->on('minsa_procedimientos.lote', '=', 'arfsis.lote')
                        ->on('minsa_procedimientos.numero', '=', 'arfsis.numero');
                }
            )
            ->where('minsa_procedimientos.periodo', 'LIKE', $anho.'%')
            ->groupBy('minsa_procedimientos.fua', 'arfsis.codigo', 'minsa_procedimientos.periodo', 'arfsis.user_login', 'arfsis.dni', 'arfsis.apenom');
        

        }
        $registros = $registros->paginate($paginacion);

        $data = [['Periodo', 'Bruto', 'Neto']];
        if($estado != 'Cambiando Pagina'){
            $resultado = $resultado->get();
            foreach ($resultado as $item) {
                $periodo = $item->PERIODO;
                $BRUTO = floatval($item->BRUTO);
                $NETO = floatval($item->NETO);
                $data[] = [$periodo, $BRUTO, $NETO];
            }
        }
        $response = [
            'registros' => $registros,
            'data'      => $data
        ];
        return response()->json($response);     


    }


}