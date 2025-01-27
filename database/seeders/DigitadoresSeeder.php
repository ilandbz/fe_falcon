<?php

namespace Database\Seeders;

use App\Models\UsuarioTrans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DigitadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/digitadores_1810.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, '|')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Establecimientos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/digitadores_1810.csv'), 'r');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        $i=0;
        while(($fila = fgetcsv($csvFile2, 2000, "|")) !== false) {
            if (!$firstLine) {                
                $registro = explode(";",(string)$fila[0]);
                $codigo = $registro[0];
                $apellido_paterno = $registro[1];
                $apellido_materno = $registro[2];
                $nombres = $registro[3];
                $userlogin = $registro[5];
                if (strlen($codigo) > 8) {
                    $codigo = substr($codigo, -8);
                }
                $digitalizador = UsuarioTrans::firstOrNew(['codigo' => $codigo]);
                if (!$digitalizador->exists){
                    $digitalizador->codigo = $codigo;
                    $digitalizador->ape_paterno = $apellido_paterno;
                    $digitalizador->ape_materno = $apellido_materno;
                    $digitalizador->primer_nombre = $nombres;
                    $digitalizador->segundo_nombre = '';
                    $digitalizador->user_login =$userlogin;
                    $digitalizador->save();
                }
            }
            $firstLine = false;
            $progressBar->advance();
        }

    }
}
