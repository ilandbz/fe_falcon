<?php

namespace App\Imports;

use App\Models\Atencion;
use App\Models\CondicionMaterna;
use App\Models\DestinoAsegurado;
use App\Models\Establecimiento;
use App\Models\GrupoRiesgo;
use App\Models\Paciente;
use App\Models\Periodo;
use App\Models\Profesional;
use App\Models\Servicio;
use App\Models\TipoAtencion;
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
        $codigo = $row['id'];
        $atencionexiste=Atencion::where('codigo', $codigo)->exists();
        if ($atencionexiste) {
            return null;
        }
        $lote = $row['lote'];
        $correlativo = $row['correlativo'];
        $cod_renaes_ipres=$row['cod_renaes_ipres'];
        $establecimiento_id=Establecimiento::where('pre_CodigoRENAES', intval($cod_renaes_ipres))->value('id');
        $componente_id = $row['componente_id'];
        $tipo_formato_id = $row['tipo_formato_id']=='A' ? 8 : $row['tipo_formato_id'];
        $disaformato = $row['cod_asegurado_1'];
        $lote_formato =$row['cod_asegurado_2'];
        $nro_formato = $row['cod_asegurado_3'];
        $nro_documento=$row['nro_documento'];
        $ape_paterno=$row['ape_paterno'];
        $ape_materno=$row['ape_materno'] == null ? '' : $row['ape_materno'];
        $primer_nombre=$row['primer_nombre'];
        $segundo_nombre=$row['segundo_nombre']==null ? '' : $row['segundo_nombre'];
        $fecha_nacimiento=str_replace("'","",$row['fecha_nacimiento']);
        $fecha_nacimiento_formato_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_nacimiento)));
        try {
            $paciente = Paciente::where('nro_documento', $nro_documento)->first();
            $sexo_id = $row['sexo_id']+1;
            if (!$paciente) {
                $paciente= Paciente::firstorCreate([
                    'tipo_documento_id' => 1,
                    'nro_documento' => $nro_documento,
                    'ape_paterno' => $ape_paterno,
                    'ape_materno' => $ape_materno,
                    'primer_nombre' => $primer_nombre,
                    'segundo_nombre' => $segundo_nombre,
                    'fecha_nacimiento' => $fecha_nacimiento_formato_mysql,
                    'sexo_id' => $sexo_id,
                ]);
            }
            $paciente_id = $paciente->id;
            $tipo_atencion_id = $row['tipo_atencion_id'];
            $tipo_atencion_id = TipoAtencion::where('codigo', $tipo_atencion_id)->value('id');
            $condicion_materna_id = $row['condicion_materna_id'];
            $condicion_materna_id = CondicionMaterna::where('codigo',$row['condicion_materna_id'])->value('id');
            $modalidad_atencion_id = $row['modalidad_atencion_id'];
            $fecha_atencion = str_replace("'","",$row['fecha_atencion']);
            $fecha_atencion_formato_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_atencion)));
            // Dividir la cadena en fecha y hora
            $partes_fecha_hora = explode(' ', $fecha_atencion);
            $hora_atencion_formato_mysql = date('H:i:s', strtotime($partes_fecha_hora[1]));
            $codigo_historia_clinica = $row['nro_historia'];
            $fecha_parto = $row['fecha_parto'];
            $fecha_parto_formato_mysql = date('Y-m-d', strtotime(str_replace('/', '-', $fecha_parto)));
            $origen_personal_id = $row['origen_personal_id'];
            $cod_prestacion=$row['cod_prestacion'];
            $servicio_id= Servicio::where('codigo', $cod_prestacion)->value('id');
            $ref_cod_renaes_id=$row['ref_cod_renaes_id'];
            $establecimiento_refiere_id = Establecimiento::where('pre_CodigoRENAES', intval($ref_cod_renaes_id))->value('id');
            $nro_hoja_referencia = $row['nro_hoja_referencia']==null ? '' : $row['nro_hoja_referencia'];
            $destino_asegurado_id=DestinoAsegurado::where('codigo', $row['destino_asegurado_id'])->value('id');
            $cod_contra_ref=$row['cod_contra_ref'];
            $establecimiento_contrarefiere_id = Establecimiento::where('pre_CodigoRENAES', intval($cod_contra_ref))->value('id');
            $nro_hoja_contr_ref=$row['nro_hoja_contr_ref']==null ? '' : $row['nro_hoja_contr_ref'];
            $fecha_ingreso_contr=date('Y-m-d', strtotime(str_replace('/', '-', $row['fecha_ingreso_contr'])));
            $fecha_alta_contr=date('Y-m-d', strtotime(str_replace('/', '-', $row['fecha_alta_contr'])));
            $fecha_fallecimiento=date('Y-m-d', strtotime(str_replace('/', '-', $row['fecha_fallecimiento'])));
            $responsable_atencion = $row['responsable_atencion'];
            $profesional_id = Profesional::where('nro_documento', $responsable_atencion)->value('id');
            $especialidad_id=$row['especialidad_id'];
            $RNE=$row['RNE'];
            $observacion=$row['observacion'] == null ? '' : $row['observacion'] ;
            $idPPDD=$row['idPPDD'];
            $idOdeSis=$row['idOdeSis'];
            $idusuariotrans = UsuarioTrans::where('codigo', $row['digitador_dni'])->value('id');
            $fecha_digitalizacion=date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $row['fecha_digitalizacion'])));
            $gruporiesgo = GrupoRiesgo::where('codigo', $row['grupo_riesgo_id'])->value('id');
            $totalvalorizacion = $row['totalvalorizacion'];
            $periodo = str_replace('-', '', $row['periodo']);
            $periodo_id= Periodo::where('codigo', $periodo)->value('id');
            $version_id=$row['version_id'];
            $estado=$row['estado'];
            return new Atencion([
                'codigo'                    => $codigo,
                'lote'                      => $lote,
                'numero'                    => $correlativo,
                'establecimiento_id'        => $establecimiento_id,
                'componente_id'             => $componente_id,
                'tipo_formato_id'           => $tipo_formato_id,
                'disaformato'               => $disaformato,
                'lote_formato'              => $lote_formato,
                'nro_formato'               => $nro_formato,
                'paciente_id'               => $paciente_id,
                'tipo_atencion_id'          => $tipo_atencion_id,
                'condicion_materna_id'      => $condicion_materna_id,
                'modalidad_atencion_id'     => $modalidad_atencion_id,
                'fecha_atencion'            => $fecha_atencion_formato_mysql,
                'hora_atencion'             => $hora_atencion_formato_mysql,
                'codigo_historia_clinica'   => $codigo_historia_clinica,
                'fecha_parto'               => $fecha_parto_formato_mysql,
                'origen_personal_id'        => $origen_personal_id,
                'servicio_id'               => $servicio_id,
                'establecimiento_refiere_id' => $establecimiento_refiere_id,
                'nrohojasrefirio'           => $nro_hoja_referencia,
                'destino_asegurado_id'      => $destino_asegurado_id,
                'establecimiento_contrarefiere_id' => $establecimiento_contrarefiere_id,
                'nrohojascontrarefiere'     => $nro_hoja_contr_ref,
                'fecha_ingreso'             => $fecha_ingreso_contr,
                'fecha_alta'                => $fecha_alta_contr,
                'fecha_fallecimiento'       => $fecha_fallecimiento,
                'profesional_id'            => $profesional_id,
                'idespecialidad'            => $especialidad_id,
                'nroespecialidad'           => $RNE,
                'observacion'               => $observacion,
                'edad'                      => 0,
                'grupo_etareo_id'           => 1,
                'autogenerado'              => 't666',
                'idPPDD'                    => $idPPDD,
                'idOdeSis'                  => $idOdeSis,
                'idusuariotrans'            => $row['digitador_dni'],
                'fechatrans'                => $fecha_digitalizacion,
                'grupo_riesgo_id'           => $gruporiesgo,
                'costo_servicio'            => 0,
                'costo_medicina'            => 0,
                'costo_insumo'              => 0,
                'costo_procedimiento'       => 0,
                'costo_total'               => $totalvalorizacion,
                'periodo_id'                => $periodo_id,
                'envio'                     => $estado,
                'supervision_id'            => 1,
                'version'                   => $version_id,
                'correlativo'               => $correlativo,
                'usuario_tran_id'           => $idusuariotrans,
            ]);
        }catch (\Throwable $th) {
            dd('Error en la importación con CORRELATIVO: ' . $correlativo, 'Mensaje de error: ' . $th->getMessage());
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