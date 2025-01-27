<?php

namespace App\Imports;

use App\Models\Insumo;
use App\Models\MinsaInsumo;
use App\Models\MinsaProcedimiento;
use App\Models\Paciente;
use App\Models\Procedimiento;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class SoloProcedimientosImportsMinsa implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Procedimiento|null
     */
    public function model(array $row)
    {
        $procedimiento_id = Procedimiento::where('PRCD_V_CODPRO_MINSA', $row['CODIGO'])->value('id');
        if($procedimiento_id==null){
            $content = $row['CODIGO'];
            $file_path = base_path('archivos/minsa/procedimientos_no_encontrados.txt');
            file_put_contents($file_path, $content . PHP_EOL, FILE_APPEND);
        }
        $cantidad = str_replace(' ', "", $row['CANTIDAD']);
        $precio_aplicado = str_replace(' ', "", $row['PRECIOAPLICADO']);
        $total = $cantidad*$precio_aplicado;
        $anho = str_replace(' ', "", $row['Periodo']);
        $mes = str_pad(str_replace(' ', "", $row['Mes']),2,'0',STR_PAD_LEFT);
        $minsaprocedimientoExists = MinsaProcedimiento::where('fua', $fua)
        ->where('procedimiento_id', $procedimiento_id)
        ->exists();
        if (!$minsaprocedimientoExists) {
            return new MinsaProcedimiento([
                'fua' => $fua,
                'lote' => $lote,
                'numero' => $numero,
                'paciente_id' => $paciente_id, 
                'procedimiento_id' => $procedimiento_id,
                'cantidad' => $cantidad,
                'precio_aplicado' => $precio_aplicado,
                'total' => $total,
                'periodo'   => $anho.$mes,
            ]);            
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