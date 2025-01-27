<?php

namespace App\Imports;

use App\Models\Insumo;
use App\Models\Medicamento;
use App\Models\MinsaProcedimiento;
use App\Models\MinsaServicio;
use App\Models\Paciente;
use App\Models\Procedimiento;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class Medicamentos_imports implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Servicio|null
     */
    public function model(array $row)
    {
        try {
            $med_CodMed = str_replace(' ', '', $row['OC_PRODUCT_CODE']);
            $med_Concen = str_replace(' ', '', $row['OC_PRODUCT_DOSE']);
            $med_Nombre = str_replace(' ', '', $row['OC_PRODUCT_NAME']);
            $med_FormaFarmaceutica = str_replace(' ', '', $row['OC_PRODUCT_TYPE2']);
            $med_Presen = str_replace(' ', '', $row['OC_PRODUCT_UNIT2']);
            $med_Petitorio = str_replace(' ', '', $row['OC_PRODUCT_PETITORIO']);
            $med_Costo = str_replace(' ', '', $row['OC_PRODUCT_UNITPRICE']);
            $med_FFDigemid = str_replace(' ', '', $row['OC_PRODUCT_TYPE2']);

            $minsamedicamentoExists = Medicamento::where('med_CodMed', $med_CodMed)
            ->exists();
            if (!$minsamedicamentoExists) {
                return new Medicamento([
                'med_CodMed' => $med_CodMed,
                'med_Concen' => $med_Concen,
                'med_Costo' => $med_Costo,
                'med_FecBaja' => null,
                'med_FFDigemid' => $med_FFDigemid,
                'med_FormaFarmaceutica' => $med_FormaFarmaceutica,
                'MED_N_FACTOR_CONSUMO' => 0,
                'med_Nombre' => $med_Nombre,
                'med_Petitorio' => $med_Petitorio,
                'med_Petitorio2005' =>  $med_Petitorio,
                'med_Petitorio2010' =>  $med_Petitorio,
                'med_Presen' => $med_Presen,
                'MED_V_FORMAFARM_SIS' => $med_FFDigemid,
                'MED_V_NOMBRE_SIS' => $med_Nombre,
                'MED_V_PRESENT_SIS' => $med_Presen,
                'MED_V_UNIDAD_CONSUMO' => $med_Presen,

                ]);            
            }
        } catch (\Throwable $th) {
            dd('Error en la importación con med_CodMed: ' . $med_CodMed, ' procedimiento ' . $th->getMessage());
        }

        

        return null;
    }
    public function batchSize(): int
    {
        return 2000;
    }
    
    public function chunkSize(): int
    {
        return 2000;
    }
}