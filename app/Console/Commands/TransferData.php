<?php

namespace App\Console\Commands;

use App\Models\Atencion;
use App\Models\AtencionDiagnostico;
use App\Models\AtencionMedicamento;
use App\Models\CondicionMaterna;
use App\Models\DestinoAsegurado;
use App\Models\Diagnostico;
use App\Models\Establecimiento;
use App\Models\Medicamento;
use Carbon\Carbon;
use App\Models\Paciente;
use App\Models\Periodo;
use App\Models\Profesional;
use App\Models\Servicio;
use App\Models\TipoAtencion;
use App\Models\TipoDocumento;
use App\Models\TipoIngresoEgreso;
use App\Models\TipoPersonalSalud;
use App\Models\UsuarioTrans;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPUnit\Framework\isNull;

class TransferData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transfer-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transferir Digitalizaciones';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener datos de la base de datos local
        $fechaactual = Carbon::now()->toDateString();
        //$fechaactual = '2024-11-13';
        $anio = Carbon::parse($fechaactual)->year;
        $codigomaximo = Atencion::whereYear('fechatrans', $anio)->max('codigo') ?? 0;
        $localData = DB::connection('local_db')
        ->table('vista_atenciones')
        ->select(
            'id',//sera el codigo
            'fua',
            'lote',
            'correlativo',
            'idOdeSis',
            'cod_renaes_ipres',
            'componente_id',
            'idPPDD',
            'cod_asegurado_1',
            'cod_asegurado_2',
            'cod_asegurado_3',
            'tipo_formato_id',
            'autogenerado',
            'tipo_documento_id',
            'nro_documento',
            'ape_paterno',
            'ape_materno',
            'primer_nombre',
            'otros_nombres',
            'fecha_nacimiento',
            'sexo_id',
            'nro_historia',
            'tipo_atencion_id',
            'condicion_materna_id',
            'modalidad_atencion_id',
            'fecha_atencion',
            'hora_atencion',
            'ref_cod_renaes_id',
            'nro_hoja_referencia',
            'cod_prestacion',
            'origen_personal_id',
            'lugar_atencion_id',//no es necesario
            'destino_asegurado_id',
            'fecha_ingreso_contr',
            'fecha_alta_contr',
            'cod_contra_ref',
            'observacion',
            'nro_hoja_contr_ref',
            'fecha_parto',
            'grupo_riesgo_id',//siempre sera 1 que no tiene
            'fecha_fallecimiento',
            'tipo_personal_salud_id',
            'etnia_id', // ya no se utiliza
            'ups',
            'tipo_doc_responsable',
            'responsable_atencion',//dni del responsable de la atencion
            'especialidad_id',
            'nroespecialidad',
            'RNE',// registro nacional de especialidad
            'anho',
            'mes',
            'digitador_dni',
            'fecha_digitalizacion',
            'hora_digitalizacion',
            'totalvalorizacion',
            'periodo',
            'estado',
            'hora_digitalizacion'
        )
        ->where('fecha_digitalizacion', 'like', $fechaactual.'%')
        ->where('id', '>',$codigomaximo)
        ->get();
        $localDataCount = $localData->count();
        $this->info('INICIANDO SINCRONIZACION '.$localDataCount .' Registros, fecha Actual : '.$fechaactual);
        $progressBar = $this->output->createProgressBar($localDataCount);
        $progressBar->start();
        foreach ($localData as $data) {
            $atencion = Atencion::where('codigo', $data->id)
            ->orWhere(function ($query) use ($data) {
                $query->where('lote', $data->lote)
                    ->where('numero', $data->correlativo);
            })
            ->exists();
            if (!$atencion) {
                $paciente = Paciente::where('nro_documento', $data->nro_documento)
                            ->orWhere(function($query) use ($data){
                                $query->where('ape_paterno', $data->ape_paterno)
                                ->where('ape_materno', $data->ape_materno)
                                ->where('primer_nombre', $data->primer_nombre)
                                ->where('otros_nombres', 'like', '%'.$data->otros_nombres.'%')
                                ;
                            })
                            ->first();
                if(!$paciente){
                    $paciente = Paciente::create([
                        'tipo_documento_id' => TipoDocumento::where('codigo', $data->tipo_documento_id)->value('id'),
                        'ape_paterno'       => $data->ape_paterno,
                        'ape_materno'       => $data->ape_materno,
                        'primer_nombre'     => $data->primer_nombre,
                        'otros_nombres'     => $data->otros_nombres,
                        'fecha_nacimiento'  => $data->fecha_nacimiento,
                        'sexo_id'           => $data->sexo_id,
                    ]);
                }
                $digitador = UsuarioTrans::where('codigo', $data->digitador_dni)->first();
                if(!$digitador){
                    $data_digitadores_local = DB::connection('local_db')
                    ->table('vista_digitadores')
                    ->select(
                        'codigo',
                        'ape_paterno',
                        'ape_materno',
                        'primer_nombre',
                        'otros_nombres',
                        'user_login',
                    )
                    ->where('codigo', $data->digitador_dni)
                    ->first();
                    UsuarioTrans::create([
                        'codigo'            => $data->digitador_dni,
                        'ape_paterno'       => $data_digitadores_local->ape_paterno,
                        'ape_materno'       => $data_digitadores_local->ape_materno,
                        'primer_nombre'     => $data_digitadores_local->primer_nombre,
                        'segundo_nombre'    => $data_digitadores_local->otros_nombres,
                        'user_login'        => $data_digitadores_local->user_login,
                    ]);
                }
                if($data->responsable_atencion!=''){
                    $profesional = Profesional::where('nro_documento', $data->responsable_atencion)->first();
                    if(!$profesional){
                        $profesional_maestros = DB::connection('local_db_maestros')
                        ->table('vista_profesionasles')
                        ->select(
                            'nro_documento',
                            'ape_paterno', 
                            'tipodocumento_id',
                            'ape_materno',
                            'primer_nombre',
                            'otros_nombres',
                            'tipopersonal_id',
                            'colegiatura',
                            'especialidad_id',
                            'nroespecialidad',
                        )
                        ->where('nro_documento', $data->responsable_atencion)
                        ->first();
                        $profesional = Profesional::Create([
                            'nro_documento' => $profesional_maestros->nro_documento,
                            'codtipodocumento' => $profesional_maestros->tipodocumento_id,
                            'ape_paterno' => $profesional_maestros->ape_paterno,
                            'ape_materno' => $profesional_maestros->ape_materno,
                            'primer_nombre' => $profesional_maestros->primer_nombre,
                            'otros_nombres' => $profesional_maestros->otros_nombres,
                            'tipopersonal_salud' => $profesional_maestros->tipopersonal_id,
                            'colegiatura' => $profesional_maestros->colegiatura,
                            'idespecialidad' => $profesional_maestros->especialidad_id,
                            'nroespecialidad' => $profesional_maestros->nroespecialidad,
                        ]);
                    }                    
                }

                $codigo = str_replace('-', '', $data->periodo);
                $periodo_id = Periodo::where('codigo', $codigo)->value('id');
                $atencion_registrado = Atencion::firstOrCreate([
                    'establecimiento_id' => Establecimiento::where('pre_CodigoRENAES', intval($data->cod_renaes_ipres))->value('id'),
                    'tipo_atencion_id' => TipoAtencion::where('codigo', $data->tipo_atencion_id)->value('id'),
                    'condicion_materna_id' => CondicionMaterna::where('codigo', $data->condicion_materna_id)->value('id'),
                    'servicio_id' => Servicio::where('codigo', $data->cod_prestacion)->value('id'),
                    'destino_asegurado_id' => DestinoAsegurado::where('codigo', $data->destino_asegurado_id)->value('id'),
                    'profesional_id' => $data->responsable_atencion=='' ? null : $profesional->id,
                    'usuario_tran_id' => $digitador->id,

                    'establecimiento_refiere_id' => $data->ref_cod_renaes_id ? Establecimiento::where('pre_CodigoRENAES', intval($data->ref_cod_renaes_id))->value('id') : null,
                    'establecimiento_contrarefiere_id' => $data->cod_contra_ref ? Establecimiento::where('pre_CodigoRENAES', intval($data->cod_contra_ref))->value('id') : null,

                    'fecha_ingreso' => $data->fecha_ingreso_contr =='' ? null : $data->fecha_ingreso_contr,
                    'fecha_alta' => $data->fecha_alta_contr =='' ? null : $data->fecha_alta_contr,

                    'fua' => $data->fua,
                    'codigo' => $data->id,
                    'lote' => $data->lote,
                    'numero' => $data->correlativo,
                    'idOdeSis' => $data->idOdeSis,
                    'componente_id' => $data->componente_id,
                    'idPPDD' => $data->idPPDD,
                    'cod_asegurado_1' => $data->cod_asegurado_1,
                    'cod_asegurado_2' => $data->cod_asegurado_2,
                    'cod_asegurado_3' => $data->cod_asegurado_3,
                    'tipo_formato_id' => 7,
                    'paciente_id' => $paciente->id,
                    'codigo_historia_clinica' => $data->nro_historia,
                    'nro_formato' => $data->nro_historia,
                    'modalidad_atencion_id' => $data->modalidad_atencion_id,
                    'fecha_atencion' => $data->fecha_atencion,
                    'hora_atencion' => $data->hora_atencion,
                    'nrohojasrefirio' => $data->nro_hoja_referencia,
                    'fecha_parto' => $data->fecha_parto,
                    'origen_personal_id' => $data->origen_personal_id,
                    'nrohojascontrarefiere' => $data->nro_hoja_contr_ref,
                    'fecha_fallecimiento' => $data->fecha_fallecimiento,
                    'idespecialidad' => $data->especialidad_id,
                    'nroespecialidad' => $data->nroespecialidad,
                    'observacion' => $data->observacion,
                    'autogenerado' => $data->autogenerado,
                    'idusuariotrans' => $data->digitador_dni,
                    'fechatrans' => $data->fecha_digitalizacion,
                    'grupo_riesgo_id' => 1,
                    'costo_servicio' => 0,
                    'costo_medicina' => 0,
                    'costo_insumo' => 0,
                    'costo_procedimiento' => 0,
                    'costo_total' => $data->totalvalorizacion,
                    'periodo_id' => $periodo_id,
                    'anho' => $data->anho,
                    'mes' => $data->mes,
                    'envio' => $data->estado,
                    'ups' => $data->ups,
                    'hora_digitalizacion' => $data->hora_digitalizacion,
                ]);

                $vista_diagnosticos = DB::connection('local_db')
                ->table('vista_diagnosticos')
                ->select(
                    'fua',
                    'fua_id',
                    'lote',
                    'correlativo',
                    'orden',
                    'diagnostico_cod',
                    'tipo_ingreso_engreso',
                    'tipo_diagnostico',
                    'fecha_digitalizacion'
                )
                ->where('fua_id',$data->id)
                ->get();
                foreach ($vista_diagnosticos as $datadiagnosticos) {
                    $diagnostico_id = Diagnostico::where('codigo', $datadiagnosticos->diagnostico_cod)->value('id');
                    $atenciondiagnostico = AtencionDiagnostico::where('diagnostico_id', $diagnostico_id)
                    ->where('atencion_id', $atencion_registrado->id)->exists();
                    if(!$atenciondiagnostico){
                        $atencioncliente = AtencionDiagnostico::create([
                            'codigo'                => $atencion_registrado->id.$datadiagnosticos->orden,
                            'atencion_id'           => $atencion_registrado->id,
                            'diagnostico_id'        => $diagnostico_id,
                            'tipo_diagnostico_id'    => $datadiagnosticos->tipo_diagnostico,
                            'tipo_ingreso_egresos_id'     => TipoIngresoEgreso::where('codigo',$datadiagnosticos->tipo_ingreso_engreso)->value('id')
                        ]);
                        $vistamedicamentosregistros = DB::connection('local_db')
                        ->table('vistamedicamentos')
                        ->select(
                            'fua',
                            'fua_id',
                            'lote',
                            'correlativo',
                            'ordendiagnostico',
                            'coddiagnostico',
                            'codmedicamento',
                            'cantidad_preescrita',
                            'cantidad_entregada',
                            'precio_unit',
                            'subtotal',
                            'fecha_digitalizacion'
                        )
                        ->where('fua_id',$data->id)
                        ->get();
                        foreach ($vistamedicamentosregistros as $datamedicamentos) {
                            $medicamento_id = Medicamento::where('med_CodMed', $datamedicamentos->codmedicamento)->value('id');
                            $atencion_id = Atencion::where('codigo', $datamedicamentos->fua_id)
                            ->orWhere(function ($query) use ($datamedicamentos) {
                                $query->where('lote', $datamedicamentos->lote)
                                    ->where('numero', $datamedicamentos->correlativo);
                            })
                            ->value('id');
                            $diagnostico_id = Diagnostico::where('codigo', $datamedicamentos->coddiagnostico)->value('id');
                            // $atenciondiagnostico = AtencionDiagnostico::where('diagnostico_id', $diagnostico_id)
                            // ->where('atencion_id', $atencion_id)->first();
                            // if(!$atenciondiagnostico){
                            //     $this->info($datamedicamentos->fua);
                            //     return 0;
                            // }
                            $atencionmedicamento = AtencionMedicamento::where('atencion_diagnostico_id', $atencioncliente->id)
                            ->exists();
                            if(!$atencionmedicamento && isset($medicamento_id)){
                                $reg = AtencionMedicamento::create([
                                    'codigo'                    => $atencion_id.$atencioncliente->id,
                                    'atencion_diagnostico_id'   => $atencioncliente->id,
                                    'medicamento_id'            => $medicamento_id,
                                    'cantidad_preescrita'       => $datamedicamentos->cantidad_preescrita,
                                    'cantidad_entregada'        => $datamedicamentos->cantidad_entregada,
                                    'precio_unitario'           => $datamedicamentos->precio_unit,
                                    'subtotal'                  => $datamedicamentos->subtotal,
                                ]);
                                $this->info($datamedicamentos->fecha_digitalizacion);
                            }
                            $progressBar->advance();
                        }



                    }
                }

            }
            $progressBar->advance();
        }
        //$this->info('Data transferido exitosamente!');
    }
}
