<?php

namespace Database\Seeders;

use App\Imports\AtencionesImport;
use App\Models\Atencion;
use App\Models\CondicionMaterna;
use App\Models\DestinoAsegurado;
use App\Models\Establecimiento;
use App\Models\GrupoEtareo;
use App\Models\GrupoRiesgo;
use App\Models\Paciente;
use App\Models\Periodo;
use App\Models\Profesional;
use App\Models\Servicio;
use App\Models\TipoAtencion;
use App\Models\UsuarioTrans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isNull;

class AtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Excel::import(new AtencionesImport, base_path('archivos/atenciones.xls'));


        
        // $csvFile = fopen(base_path('archivos/pruebas.csv'), 'r');
        // $nro_registros = -1;
        // while (($datum = fgetcsv($csvFile, 1000, ',')) !== false){
        //     $nro_registros +=1;
        // }
        // fclose($csvFile);
        // $this->command->getOutput()->writeln('Iniciando Importación de Atenciones...');
        // $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        // $csvFile2 = fopen(base_path('archivos/pruebas.csv'), 'r');
        // $this->command->getOutput()->writeln("Importando Datos... ");
        // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        // $progressBar->start();
        // $firstLine = true;
        // while(($fila = fgetcsv($csvFile2, 3000, "}")) !== false) {
        //     if(!$firstLine)
        //     {
        //         $registro = explode(",",(string)$fila[0]);
        //         $usuario_trans_id = UsuarioTrans::where('codigo', str_replace('"', '', $registro[67]))->value('id');   
        //         $paciente_id = Paciente::where('nro_documento', str_replace('"', '', $registro[17]))->value('id');
        //         if($paciente_id == null){
        //             Paciente::firstOrCreate([
        //                 'tipo_documento_id' => 1,
        //                 'nro_documento' => str_replace('"', '', $registro[17]),
        //                 'ape_paterno' => str_replace('"', '', $registro[26]),
        //                 'ape_materno' => str_replace('"', '', $registro[27]),
        //                 'primer_nombre' => str_replace('"', '', $registro[28]),
        //                 'segundo_nombre' => str_replace('"', '', $registro[29]),
        //                 'fecha_nacimiento' => '2024-01-01',
        //                 'sexo_id' => 2,
        //             ]);
        //         }
        //         $atencion = Atencion::where([
        //             'codigo' => $registro[0]
        //         ])->first();
        //         if (!$atencion) {
        //             echo $registro[17];
        //             Atencion::firstOrCreate([
        //                 'codigo'                    => str_replace('"', '', $registro[0]),
        //                 'lote'                      => str_replace('"', '', $registro[3]),
        //                 'numero'                    => str_replace('"', '', $registro[4]),
        //                 'establecimiento_id'        => Establecimiento::where('codigo', str_replace('"', '', $registro[9]))->value('id'),
        //                 'componente_id'             => str_replace('"', '', $registro[10]),
        //                 'tipo_formato_id'           => str_replace('"', '', $registro[11])=='' ? NULL : str_replace('"', '', $registro[11]),
        //                 'disaformato'               => str_replace('"', '', $registro[13]),
        //                 'lote_formato'              => str_replace('"', '', $registro[14]),
        //                 'nro_formato'               => str_replace('"', '', $registro[15]),
        //                 'paciente_id'               => $paciente_id,
        //                 'tipo_atencion_id'          => TipoAtencion::where('codigo', str_replace('"', '', $registro[32]))->value('id'),
        //                 'condicion_materna_id'      => CondicionMaterna::where('codigo', str_replace('"', '', $registro[33]))->value('id'),
        //                 'modalidad_atencion_id'     => str_replace('"', '', $registro[34])=='' ? NULL : str_replace('"', '', $registro[34]),
        //                 'fecha_atencion'            => str_replace('"', '', $registro[37]),
        //                 'hora_atencion'             => str_replace('"', '', $registro[38]),
        //                 'codigo_historia_clinica'   => str_replace('"', '', $registro[39]),
        //                 'fecha_parto'               => str_replace('"', '', $registro[41])=='NULL' ? NULL : str_replace('"', '', $registro[41]),
        //                 'origen_personal_id'        => str_replace('"', '', $registro[42]),
        //                 'servicio_id'               => Servicio::where('codigo', str_replace('"', '', $registro[43]))->value('id'),
        //                 'establecimiento_refiere_id' => Establecimiento::where('codigo', str_replace('"', '', $registro[44]))->value('id'),
        //                 'nrohojasrefirio'           => str_replace('"', '', $registro[45]),
        //                 'destino_asegurado_id'      => DestinoAsegurado::where('codigo', str_replace('"', '', $registro[46]))->value('id'),
        //                 'establecimiento_contrarefiere_id' => Establecimiento::where('codigo', str_replace('"', '', $registro[47]))->value('id'),
        //                 'nrohojascontrarefiere'     => str_replace('"', '', $registro[48]),
        //                 'fecha_ingreso'             => str_replace('"', '', $registro[49]),
        //                 'fecha_alta'                => str_replace('"', '', $registro[50]),
        //                 'fecha_fallecimiento'       => str_replace('"', '', $registro[51])=='NULL' ? NULL : str_replace('"', '', $registro[51]),
        //                 'profesional_id'            => Profesional::where('nro_documento', str_replace('"', '', $registro[52]))->value('id'),
        //                 'idespecialidad'            => str_replace('"', '', $registro[56]),
        //                 'nroespecialidad'           => str_replace('"', '', $registro[57]),
        //                 'observacion'               => str_replace('"', '', $registro[58]),
        //                 'edad'                      => str_replace('"', '', $registro[59]),
        //                 'grupo_etareo_id'           => str_replace('"', '', $registro[63]),
        //                 'autogenerado'              => str_replace('"', '', $registro[64]),
        //                 'idPPDD'                    => str_replace('"', '', $registro[65]),
        //                 'idOdeSis'                  => str_replace('"', '', $registro[66]),
        //                 'idusuariotrans'            => str_replace('"', '', $registro[67]),
        //                 'fechatrans'                => str_replace('"', '', $registro[84])=='' ? NULL : str_replace('"', '', $registro[84]),
        //                 'grupo_riesgo_id'           => GrupoRiesgo::where('codigo', str_replace('"', '', $registro[69]))->value('id'),
        //                 'costo_servicio'            => str_replace('"', '', $registro[70]),
        //                 'costo_medicina'            => str_replace('"', '', $registro[71]),
        //                 'costo_insumo'              => str_replace('"', '', $registro[72]),
        //                 'costo_procedimiento'       => str_replace('"', '', $registro[73]),
        //                 'costo_total'               => str_replace('"', '', $registro[74]),
        //                 'periodo_id'                => Periodo::where('anho_periodo', str_replace('"', '', $registro[75]))->where('mes', str_replace('"', '', $registro[76]))->value('id'),
        //                 'envio'                     => str_replace('"', '', $registro[77]),
        //                 'supervision_id'            => str_replace('"', '', $registro[78])==''? NULL : str_replace('"', '', $registro[78]),
        //                 'version'                   => str_replace('"', '', $registro[80]),
        //                 'correlativo'               => str_replace('"', '', $registro[4]),
        //                 'usuario_tran_id'           => $usuario_trans_id,
        //             ]);
        //         }

               
        //         $this->command->getOutput()->writeln('indice : '.$registro[0]);
        //         $progressBar->advance();
        //     }
        //     $firstLine = false;
        //}
    }
}
