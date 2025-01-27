<?php

namespace App\Imports;

use App\Models\Medicamento;
use App\Models\MinsaMedicamento;
use App\Models\Paciente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class MedicamentoImports implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Paciente|null
     */
    public function model(array $row)
    {
        $fua = str_replace(' ', "", $row['FUA']);
        $registro = explode('-',(string)$fua);
        $lote=$registro[1];
        $numero = $registro[2];
        $nro_documento=str_replace(' ', "", $row['ate_dni']);
        $codigo = str_pad(str_replace(' ', "", $row['CODIGO']), 5, '0', STR_PAD_LEFT);
        $medicamento_id = Medicamento::where('med_CodMed', $codigo)->value('id');
        $cantidad = str_replace(' ', "", $row['CANTIDAD']);
        $precio_aplicado = str_replace(' ', "", $row['PRECIOAPLICADO']);
        $total = $cantidad*$precio_aplicado;
        $anho = str_replace(' ', "", $row['Periodo']);
        $mes = str_pad(str_replace(' ', "", $row['Mes']),2,'0',STR_PAD_LEFT);
        $minsamedicamentoExists = MinsaMedicamento::where('fua', $fua)
        ->where('medicamento_id', $medicamento_id)
        ->exists();
        //$estado=0;
        $estado=str_replace(' ', "", $row['Observado_PSA'])=='NoObs' ? 0 : 1;
        if (!$minsamedicamentoExists) {
            if($nro_documento=='NULL'){
                $Apellidos_Nom = explode(" ",(string)$row['apenom']);
                $paciente_id = count($Apellidos_Nom) > 2
                    ? Paciente::where('ape_paterno', $Apellidos_Nom[0])
                        ->where('ape_materno', $Apellidos_Nom[1])
                        ->where('primer_nombre', $Apellidos_Nom[2])
                        ->value('id')
                    : null;
            }else{
                $paciente_id=Paciente::where('nro_documento', $nro_documento)
                ->value('id');
            }
            return new MinsaMedicamento([
                'fua' => $fua,
                'lote' => $lote,
                'numero' => $numero,
                'paciente_id' => $paciente_id, 
                'medicamento_id' => $medicamento_id,
                'cantidad' => $cantidad,
                'precio_aplicado' => $precio_aplicado,
                'total' => $total,
                'periodo'   => $anho.$mes,
                'estado'    => $estado,
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