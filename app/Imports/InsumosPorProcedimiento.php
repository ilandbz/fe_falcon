<?php

namespace App\Imports;

use App\Models\Insumo;
use App\Models\MinsaInsumo;
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
class InsumosPorProcedimiento implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Servicio|null
     */
    public function model(array $row)
    {
        try {
            $cod_cpt = str_replace(' ', '', $row['Cod CPT']);
            $cod_sismed = str_replace(' ', '', $row['Cod SISMED']);
            $Pres = str_replace(' ', '', $row['Pres']);
            $Cantidad = str_replace(' ', '', $row['Cantidad']);

            $procedimiento = Procedimiento::where('PRCD_V_CODPROCEDIMIENTO', $cod_cpt)->first();
            $insumo = Insumo::where('ins_CodIns', 'like', '%'. $cod_sismed.'%')->first();

            if($cod_sismed!='' && $Cantidad!='' && $procedimiento && $insumo){
                // $procedimiento->menus()->attach($insumo->id, ['presentacion' => $Pres, 'cantidad' => $Cantidad]);

                $procedimiento->insumos()->syncWithoutDetaching([
                    $insumo->id => ['presentacion' => $Pres, 'cantidad' => $Cantidad]
                ]);
            }


        } catch (\Throwable $th) {
            dd('Error en la importación con cod_cpt: ' . $cod_cpt, ' cod_sismed: '.$cod_sismed.' Mensaje de error: ' . $th->getMessage());
        }

        

        return null;
    }
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}