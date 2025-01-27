<?php

namespace App\Imports;

use App\Models\Insumo;
use App\Models\MinsaInsumo;
use App\Models\Paciente;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
HeadingRowFormatter::default('none');
class InsumoImports implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{

    
    /**
     * @param array $row
     *
     * @return Paciente|null
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
        // $codigo = str_pad(str_replace(' ', "", $row[16]), 5, '0', STR_PAD_LEFT);
        // $insumo_id = Insumo::where('ins_CodIns', $codigo)->value('id');
        // $cantidad = str_replace(' ', "", $row[17]);
        // $precio_aplicado = str_replace(' ', "", $row[18]);
        // $total = $cantidad*$precio_aplicado;
        // $anho = str_replace(' ', "", $row[21]);
        // $mes = str_pad(str_replace(' ', "", $row[22]),2,'0',STR_PAD_LEFT);

        // $minsainsumoExists = MinsaInsumo::where('fua', $fua)
        // ->where('insumo_id', $insumo_id)
        // ->exists();
        // if (!$minsainsumoExists) {
        //     return new MinsaInsumo([
        //         'fua' => $fua,
        //         'lote' => $lote,
        //         'numero' => $numero,
        //         'paciente_id' => $paciente_id, 
        //         'insumo_id' => $insumo_id,
        //         'cantidad' => $cantidad,
        //         'precio_aplicado' => $precio_aplicado,
        //         'total' => $total,
        //         'periodo'   => $anho.$mes,
        //     ]);
        // }

        //2022

        $fua = str_replace(' ', '', $row['FUA']);
        $registro = explode('-', (string) $fua);
        $lote = $registro[1];
        $numero = $registro[2];
        $nro_documento = str_pad(trim($row['ate_dni']), 8, '0', STR_PAD_LEFT);
        try {
            $codigo = str_pad(str_replace(' ', "", $row['cod_insumos']), 5, '0', STR_PAD_LEFT);
            $insumo_id = Insumo::where('ins_CodIns', $codigo)->value('id');
            $cantidad = str_replace(' ', "", $row['CANTIDAD']);
            $precio_aplicado = str_replace(' ', "", $row['PRECIOAPLICADO']);
            $total = $cantidad*$precio_aplicado;
            $anho = str_replace(' ', "", $row['Periodo']);
            $mes = str_pad(str_replace(' ', "", $row['Mes']),2,'0',STR_PAD_LEFT);
            $estado=0;
            // $estado=str_replace(' ', "", $row['Observado_PSA'])=='NoObs' ? 0 : 1;
            $minsainsumoExists = MinsaInsumo::where('fua', $fua)
            ->where('insumo_id', $insumo_id)
            ->exists();
            if (!$minsainsumoExists) {
                if ($nro_documento === 'NULL') {
                    $Apellidos_Nom = explode(' ', (string) $row['Apellidos_Nom']);
                    $paciente_id = count($Apellidos_Nom) > 2
                        ? Paciente::where('ape_paterno', $Apellidos_Nom[0])
                            ->where('ape_materno', $Apellidos_Nom[1])
                            ->where('primer_nombre', $Apellidos_Nom[2])
                            ->value('id')
                        : null;
                } else {
                    $paciente_id = Paciente::where('nro_documento', $nro_documento)->value('id');
                }
                return new MinsaInsumo([
                    'fua' => $fua,
                    'lote' => $lote,
                    'numero' => $numero,
                    'paciente_id' => $paciente_id, 
                    'insumo_id' => $insumo_id,
                    'cantidad' => $cantidad,
                    'precio_aplicado' => $precio_aplicado,
                    'total' => $total,
                    'periodo'   => $anho.$mes,
                    'estado'    => $estado,
                ]);
                echo 'Registrado : '.$fua;
            }
        } catch (\Throwable $th) {
            dd('Error en la importación con FUA: ' . $fua, 'Mensaje de error: ' . $th->getMessage());
        }
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    // public function headingRow(): int
    // {
    //     return 2;
    // }
}