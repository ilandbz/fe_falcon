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
class ProcedimientoImports implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Procedimiento|null
     */
    public function model(array $row)
    {

        //2021
        // $fua = str_replace(' ', '', $row[0]);
        // $registro = explode('-', (string) $fua);
        // $lote = $registro[1];
        // $numero = $registro[2];
        // $nro_documento = str_pad(trim($row[3]), 8, '0', STR_PAD_LEFT);
        // $Apellidos_Nom = explode(' ', (string) $row[4]);
        // if ($nro_documento === 'NULL') {
        //     $paciente_id = count($Apellidos_Nom) > 2
        //         ? Paciente::where('ape_paterno', $Apellidos_Nom[0])
        //             ->where('ape_materno', $Apellidos_Nom[1])
        //             ->where('primer_nombre', $Apellidos_Nom[2])
        //             ->value('id')
        //         : null;
        // } else {
        //     $paciente_id = Paciente::where('nro_documento', $nro_documento)->value('id');
        // }
        // //$codigo = str_pad(str_replace(' ', "", $row[16]), 5, '0', STR_PAD_LEFT);
        // $procedimiento_id = Procedimiento::where('PRCD_V_CODPRO_MINSA', $row[16])->value('id');
        // if($procedimiento_id==null){
        //     $content = $row[16];
        //     $file_path = base_path('archivos/minsa/procedimientos_no_encontrados.txt');
        //     file_put_contents($file_path, $content . PHP_EOL, FILE_APPEND);
        // }
        // $cantidad = str_replace(' ', "", $row[17]);
        // $precio_aplicado = str_replace(' ', "", $row[18]);
        // $total = $cantidad*$precio_aplicado;
        // $anho = str_replace(' ', "", $row[21]);
        // $mes = str_pad(str_replace(' ', "", $row[22]),2,'0',STR_PAD_LEFT);
        // $minsaprocedimientoExists = MinsaProcedimiento::where('fua', $fua)
        // ->where('procedimiento_id', $procedimiento_id)
        // ->exists();
        // if (!$minsaprocedimientoExists) {
        //     return new MinsaProcedimiento([
        //         'fua' => $fua,
        //         'lote' => $lote,
        //         'numero' => $numero,
        //         'paciente_id' => $paciente_id, 
        //         'procedimiento_id' => $procedimiento_id,
        //         'cantidad' => $cantidad,
        //         'precio_aplicado' => $precio_aplicado,
        //         'total' => $total,
        //         'periodo'   => $anho.$mes,
        //     ]);            
        // }

        // 2022

        try {
            $fua = str_replace(' ', '', $row['FUA']);
            $registro = explode('-', (string) $fua);
            $lote = $registro[1];
            $numero = $registro[2];
            $nro_documento = str_pad(trim($row['ate_dni']), 8, '0', STR_PAD_LEFT);
            //$codigo = str_pad(str_replace(' ', "", $row[16]), 5, '0', STR_PAD_LEFT);
            $procedimiento_id = Procedimiento::where('PRCD_V_CODPRO_MINSA', $row['CODIGO'])
            ->orWhere('PRCD_V_CODPROCEDIMIENTO', $row['CODIGO'])
            ->orWhere('PRCD_ID_PROCEDIMIENTO', $row['CODIGO'])
            ->value('id');
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
            $estado=0;
            //$estado=str_replace(' ', "", $row['Observado_PSA'])=='NoObs' ? 0 : 1;
            $minsaprocedimientoExists = MinsaProcedimiento::where('fua', $fua)
            ->where('procedimiento_id', $procedimiento_id)
            ->exists();
            if (!$minsaprocedimientoExists) {
                if ($nro_documento === 'NULL') {
                    $Apellidos_Nom = explode(' ', (string) $row['apenom']);
                    $paciente_id = count($Apellidos_Nom) > 2
                        ? Paciente::where('ape_paterno', $Apellidos_Nom[0])
                            ->where('ape_materno', $Apellidos_Nom[1])
                            ->where('primer_nombre', $Apellidos_Nom[2])
                            ->value('id')
                        : null;
                }else{
                    $paciente_id = Paciente::where('nro_documento', $nro_documento)->value('id');
                }
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
                    'estado'    => $estado,
                ]);            
            }
        } catch (\Throwable $th) {
            dd('Error en la importación con FUA: ' . $fua, ' procedimiento '.$procedimiento_id.' CODIGO EN EL EXCEL'.$row['cod_CPT'].' Mensaje de error: ' . $th->getMessage());
        }
        return null;
    }
    public function batchSize(): int
    {
        return 3000;
    }
    
    public function chunkSize(): int
    {
        return 3000;
    }
}