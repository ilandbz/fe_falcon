<?php
namespace App\Http\Traits;

use App\Models\AtencionInsumo;
use App\Models\AtencionMedicamento;
use App\Models\AtencionProcedimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait AtencionTrait
{

    public static function MedicamentosByAtencion(Request $request){
        $atencion_id=$request->atencion_id;
        $registros = AtencionMedicamento::select(
            'medicamentos.med_CodMed as codigo',
            'medicamentos.med_CodMed as codigo',
            'atencion_medicamentos.cantidad_preescrita',
            'atencion_medicamentos.cantidad_entregada',
            'medicamentos.med_Nombre',
            DB::raw('COALESCE((SELECT PREOPE FROM precio_medicamentos pm WHERE atencion_medicamentos.medicamento_id = pm.medicamento_id AND CPERIODO = FORMAT(atencions.fecha_atencion, "YYYYMM") LIMIT 1), 0) AS valor')
        )
            ->join('medicamentos', 'atencion_medicamentos.medicamento_id', '=', 'medicamentos.id')
            ->join('atencion_diagnosticos', 'atencion_medicamentos.atencion_diagnostico_id', '=', 'atencion_diagnosticos.id')
            ->join('atencions', 'atencion_diagnosticos.atencion_id', '=', 'atencions.id')
            ->where('atencion_diagnosticos.atencion_id', $atencion_id)
            ->get();
        
        $total = $registros->sum(function ($registro) {
            return $registro->valor * $registro->cantidad_entregada;
        });
        
        return [
            'registros' => $registros,
            'total' => $total,
        ];
        // return DB::select("
        //     SELECT 
        //     m.med_CodMed AS codigo, 
        //     am.cantidad_entregada, 
        //     m.med_Nombre,
        //     COALESCE(
        //     (SELECT PREOPE FROM precio_medicamentos pm WHERE am.medicamento_id = pm.medicamento_id AND CPERIODO = FORMAT(atencions.fecha_atencion, 'YYYYMM') LIMIT 1),
        //     0
        //     ) AS valor
        //     FROM 
        //         atencion_medicamentos am
        //         JOIN medicamentos m ON am.medicamento_id = m.id
        //         JOIN atencion_diagnosticos ad ON am.atencion_diagnostico_id = ad.id
        //         JOIN atencions ON ad.atencion_id = atencions.id
        //     WHERE 
        //     ad.atencion_id = ? ;
        // ",[
        //     $atencion_id
        // ]);
    }
    public static function InsumosByAtencion(Request $request){
        //$atencion_id=strval($request->atencion_id);
        $registros = AtencionInsumo::select(
            'insumos.ins_CodIns as codigo',
            'atencion_insumos.cantidad_entregada',
            'insumos.ins_Nombre',
            DB::raw('COALESCE((SELECT PREOPE FROM precio_insumos pi WHERE atencion_insumos.insumo_id = pi.insumo_id AND CPERIODO = FORMAT(atencions.fecha_atencion, "YYYYMM") LIMIT 1), 0) AS valor')
        )
        ->join('insumos', 'atencion_insumos.insumo_id', '=', 'insumos.id')
        ->join('atencion_diagnosticos', 'atencion_insumos.atencion_diagnostico_id', '=', 'atencion_diagnosticos.id')
        ->join('atencions', 'atencion_diagnosticos.atencion_id', '=', 'atencions.id')
        ->where('atencion_diagnosticos.atencion_id', 46)
        ->get();
        $total = $registros->sum(function ($registro) {
            return $registro->valor * $registro->cantidad_entregada;
        });
        return [
            'registros' => $registros,
            'total' => $total,
        ];

        // return DB::select("
        //     SELECT 
        //     i.ins_CodIns AS codigo, 
        //     ai.cantidad_entregada, 
        //     i.ins_Nombre,
        //     COALESCE(
        //     (SELECT PREOPE FROM precio_insumos pi WHERE ai.insumo_id = pi.insumo_id AND CPERIODO = FORMAT(atencions.fecha_atencion, 'YYYYMM') LIMIT 1),
        //     0
        //     ) AS valor
        //     FROM 
        //         atencion_insumos ai
        //         JOIN insumos i ON ai.insumo_id = i.id
        //         JOIN atencion_diagnosticos ad ON ai.atencion_diagnostico_id = ad.id
        //         JOIN atencions ON ad.atencion_id = atencions.id
        //     WHERE 
        //     ad.atencion_id = ? ;
        // ",[
        //     $atencion_id
        // ]);
    }
    public static function ProcedimientosByAtencion(Request $request){
        $atencion_id=$request->atencion_id;
        $registros = AtencionProcedimiento::select(
                    'procedimientos.PRCD_V_CODPRO_MINSA as codigo',
                    'atencion_procedimientos.apro_CantEjecutado as cantidad',
                    'procedimientos.PRCD_V_DESPROCEDIMIENTO as nombre',
                    DB::raw('COALESCE((SELECT nivel2 FROM precio_procedimientos pp WHERE pp.procedimiento_id = atencion_procedimientos.procedimiento_id AND periodo = FORMAT(atencions.fecha_atencion, "YYYYMM") LIMIT 1), 0) AS valor')
                )
                ->join('procedimientos', 'atencion_procedimientos.procedimiento_id', '=', 'procedimientos.id')
                ->join('atencion_diagnosticos', 'atencion_procedimientos.atencion_diagnostico_id', '=', 'atencion_diagnosticos.id')
                ->join('atencions', 'atencion_diagnosticos.atencion_id', '=', 'atencions.id')
                ->where('atencion_diagnosticos.atencion_id', $atencion_id)
                ->get();
                
                $total = $registros->sum('cantidad*valor');
                // $total = $registros->sum(function ($registro) {
                //     return $registro->valor * $registro->cantidad;
                // });
            
            return response()->json([
                'registros' => $registros,
                'total' => $total,
            ]);
        // return DB::select("
        //     select p.PRCD_V_CODPRO_MINSA as codigo,
        //     ap.apro_CantEjecutado as cantidad,
        //     p.PRCD_V_DESPROCEDIMIENTO as nombre,
        //                 COALESCE(
        //                 (SELECT nivel2 FROM precio_procedimientos pp WHERE pp.procedimiento_id = ap.procedimiento_id 
        //                 AND periodo = FORMAT(atencions.fecha_atencion, 'YYYYMM') LIMIT 1),
        //                 0
        //                 ) AS valor
        //     from atencion_procedimientos ap
        //     join procedimientos p on ap.procedimiento_id=p.id
        //     JOIN atencion_diagnosticos ad ON ap.atencion_diagnostico_id = ad.id
        //     JOIN atencions ON ad.atencion_id = atencions.id
        //     WHERE 
        //                 ad.atencion_id = ? ;
        // ",[
        //     $atencion_id
        // ]);
    }    
}