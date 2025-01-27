<?php

namespace Database\Seeders;

use App\Models\Profesional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/profesionales.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, '|')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de profesionales...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/profesionales.csv'), 'r');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        $i=0;
        while(($fila = fgetcsv($csvFile2, 2000, "|")) !== false) {
            if (!$firstLine) {                
                $registro = explode(",",(string)$fila[0]);
                $nro_documento = $registro[0];
                $profesional = Profesional::where('nro_documento', $nro_documento)->first();
                if (!$profesional){
                    $codigo_tipo_documento = $registro[1];
                    $ape_paterno = $registro[2];
                    $ape_materno = $registro[3];
                    $primer_nombre = $registro[4];
                    $otros_nombres = $registro[5];
                    $idTipoPersonalSalud = $registro[6];
                    $nrocolegiatura = $registro[7];
                    $idespecialidad = $registro[8];
                    $nroespecialidad = $registro[9];
                    Profesional::Create([
                        'nro_documento' => $nro_documento,
                        'codtipodocumento' => $codigo_tipo_documento,
                        'ape_paterno' => $ape_paterno,
                        'ape_materno' => $ape_materno,
                        'primer_nombre' => $primer_nombre,
                        'otros_nombres' => $otros_nombres,
                        'tipopersonal_salud' => $idTipoPersonalSalud,
                        'colegiatura' => $nrocolegiatura,
                        'idespecialidad' => $idespecialidad=='' ? null : $idespecialidad,
                        'nroespecialidad' => $nroespecialidad,
                    ]);
                }
            }
            $firstLine = false;
            $progressBar->advance();
        }

        $csvFile = fopen(base_path('archivos/atenciones.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, ',')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Profesional...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/atenciones.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        while(($fila = fgetcsv($csvFile2, 3000, ",")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                $nroDocumento = str_replace('"', "", $registro[52]);
                $profesional = Profesional::firstOrNew(['nro_documento' => $nroDocumento]);
                if (!$profesional->exists) {
                    $profesional->descripcion = str_replace('"', "", $registro[53]);
                    $profesional->tipopersonal_salud = str_replace('"', "", $registro[54]);
                    $profesional->colegiatura = str_replace('"', "", $registro[55]);
                    $profesional->save();
                    //usleep(1000);
                    $progressBar->advance();
                }


                //usleep(1000);
                $progressBar->advance();
            }
            $firstLine = false;
        }
    }
}
