<?php

namespace Database\Seeders;

use App\Models\Atencion;
use App\Models\AtencionDiagnostico;
use App\Models\Diagnostico;
use App\Models\TipoDiagnostico;
use App\Models\TipoIngresoEgreso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtencionDiagnosticoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/atencion_diagnosticos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, ',')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de atencion_diagnosticos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/atencion_diagnosticos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        while(($fila = fgetcsv($csvFile2, 2000, ",")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                $codigo = $registro[0];
                //$this->command->getOutput()->writeln(str_replace('"', "", $registro[3]));
                AtencionDiagnostico::firstOrCreate([
                    'codigo'        => str_replace('"', '', $codigo),
                    'atencion_id'   => Atencion::where('codigo', str_replace('"', '', $registro[1]))->value('id'),
                    'diagnostico_id'=> Diagnostico::where('codigo', str_replace('"', "", $registro[3]))->value('id'),
                    'tipo_ingreso_egresos_id'   => TipoIngresoEgreso::where('codigo', str_replace('"', '', $registro[4]))->value('id'),
                    'tipo_diagnostico_id'   => TipoDiagnostico::where('codigo', str_replace('"', '', $registro[5]))->value('id'),
                ]);
                //usleep(500);
                $progressBar->advance();
            }
            $firstLine = false;
        }
    }
}
