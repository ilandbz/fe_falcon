<?php

namespace App\Imports;

use App\Models\Medicamento;
use App\Models\MinsaMedicamento;
use App\Models\Insumo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class InsumoSheetImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Insumo|null
     */
    public function model(array $row)
    {
        $ins_CodIns = str_replace(' ', "", $row['OC_PRESTATION_OBJECTID']);
        $ins_Nombre = str_replace(' ', "", $row['OC_PRESTATION_DESCRIPTION']);
        $ins_FormaFarmaceutica = str_replace(' ', "", $row['OC_PRESTATION_CATEGORIES']);
        $ins_Presen = str_replace(' ', "", $row['OC_PRESTATION_UNIT2']);
        $ins_Concen = str_replace(' ', "", $row['OC_PRESTATION_FACTOR2']);
        $ins_Costo = str_replace(' ', "", $row['OC_PRESTATION_PRICE']);
        $ins_Observacion = '';
        $ins_Petitorio = str_replace(' ', "", $row['OC_PRESTATION_PETITORIO']);
        $INSU_V_NOMBRE_SIS = str_replace(' ', "", $row['OC_PRESTATION_DESCRIPTION']);
        $INSU_V_PRESENT_SIS = str_replace(' ', "", $row['OC_PRESTATION_UNIT2']);
        $INSU_V_FORMAFARM_SIS = str_replace(' ', "", $row['OC_PRESTATION_CATEGORIES']);
        $INSU_V_UNIDAD_CONSUMO = str_replace(' ', "", $row['OC_PRESTATION_UNIT2']);
        $INSU_N_FACTOR_CONSUMO = str_replace(' ', "", $row['OC_PRESTATION_PRICE']);


        $insumoExists = Insumo::where('ins_CodIns', $ins_CodIns)
        ->exists();
        if (!$insumoExists) {
            return new Insumo([
                'ins_CodIns' => $ins_CodIns,
                'ins_Nombre' => $ins_Nombre,
                'ins_FormaFarmaceutica' => $ins_FormaFarmaceutica,
                'ins_Presen' => $ins_Presen,
                'ins_Concen' => $ins_Concen,
                'ins_Costo' => $ins_Costo,
                'ins_Observacion' => $ins_Observacion,
                'ins_Petitorio' => $ins_Petitorio,
                'INSU_V_NOMBRE_SIS' => $INSU_V_NOMBRE_SIS,
                'INSU_V_PRESENT_SIS' => $INSU_V_PRESENT_SIS,
                'INSU_V_FORMAFARM_SIS' => $INSU_V_FORMAFARM_SIS,
                'INSU_V_UNIDAD_CONSUMO' => $INSU_V_UNIDAD_CONSUMO,
                'INSU_N_FACTOR_CONSUMO' => $INSU_N_FACTOR_CONSUMO
            ]);
        }
        return null;

    }
    public function batchSize(): int
    {
        return 100;
    }
    
    public function chunkSize(): int
    {
        return 100;
    }

}