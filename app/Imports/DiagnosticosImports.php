<?php

namespace App\Imports;

use App\Models\Atencion;
use App\Models\AtencionDiagnostico;
use App\Models\DestinoAsegurado;
use App\Models\Diagnostico;
use App\Models\Establecimiento;
use App\Models\GrupoRiesgo;
use App\Models\Paciente;
use App\Models\Periodo;
use App\Models\Profesional;
use App\Models\Servicio;
use App\Models\TipoDiagnostico;
use App\Models\TipoIngresoEgreso;
use App\Models\UsuarioTrans;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class AtencionesImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Paciente|null
     */
    public function model(array $row)
    {
        $codigo = $row['OBJECTID'];
        $atencion_id = $row['atencion_id'];
        $diagnostico_codigo = $row['codigo'];
        $nro = $row['nro'];
        $tipo_diagnostico_id = $row['tipo_diagnostico']+1;
        $ingreso_egreso = $row['ingreso_egreso'];
        try {
            return new AtencionDiagnostico([
                'codigo'                    => $codigo,
                'atencion_id'               => $atencion_id,
                'diagnostico_id'            => Diagnostico::where('codigo', $diagnostico_codigo)->value('id'),
                'tipo_ingreso_egresos_id'   => TipoIngresoEgreso::where('codigo', $ingreso_egreso)>value('id'),
                'tipo_diagnostico_id'       => $tipo_diagnostico_id,
            ]);
        }catch (\Throwable $th) {
            dd('Error en la importación con CODIGO: ' . $codigo, 'Mensaje de error: ' . $th->getMessage());
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