<?php

namespace App\Imports;

use App\Models\MinsaInsumo;
use App\Models\MinsaMedicamento;
use App\Models\MinsaProcedimiento;
use App\Models\Paciente;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class PacienteImports implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Paciente|null
     */
    public function model(array $row)
    {
        //SUBIR LOS DNI NULOS
        $fua = str_replace(' ', '', $row['FUA']);
        $Apellidos_Nom = explode(" ",(string)$row['apenom']);
        $ape_paterno = $Apellidos_Nom[0];
        $ape_materno = $Apellidos_Nom[1] ?? '';
        $primer_nombre = $Apellidos_Nom[2] ?? '';

        $segundo_nombre = $row['ate_snom']=='NULL' ? '' : $row['ate_snom'];
        
        $nroDocumento =  null;
        $paciente = Paciente::where([
            'ape_paterno' => $ape_paterno,
            'ape_materno' => $ape_materno,
            'primer_nombre' => $primer_nombre
        ])->first();
        if(!$paciente){
            $paciente = Paciente::firstOrCreate([
                'tipo_documento_id' => 1,
                'nro_documento' => $nroDocumento,
                'ape_paterno' => $ape_paterno,
                'ape_materno' => $ape_materno,
                'primer_nombre' => $primer_nombre,
                'segundo_nombre' => $segundo_nombre,
                'fecha_nacimiento' => '2024-01-01',
                'sexo_id' => 2,
            ]);   
        }
        MinsaInsumo::where('fua',$fua)->where('paciente_id', null)->update(['paciente_id'   => $paciente->id]);
        MinsaProcedimiento::where('fua',$fua)->where('paciente_id', null)->update(['paciente_id'   => $paciente->id]);
        MinsaMedicamento::where('fua',$fua)->where('paciente_id', null)->update(['paciente_id'   => $paciente->id]);
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