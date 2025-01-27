<?php

namespace Database\Seeders;

use App\Models\Establecimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstablecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/establecimientos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, '|')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Establecimientos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/establecimientos.csv'), 'r');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        $i=0;
        while(($fila = fgetcsv($csvFile2, 2000, "|")) !== false) {
            if (!$firstLine) {                
                $registro = explode(",",(string)$fila[0]);
                $pre_IdEESS = $registro[0];
                $pre_Nombre = $registro[1];
                $pre_Afilia = $registro[2];
                $pre_UCI = $registro[3];
                $pre_IdCategoriaEESS = $registro[4];
                $pre_IdDisa = $registro[5];
                $pre_IdOdsis = $registro[6];
                $pre_IdUbigeo = $registro[7];
                $pre_CodEjeAdm = $registro[8];
                $pre_Vrae = $registro[9];
                $pre_Umbral = $registro[10];
                $pre_idIntervencion = $registro[11];
                $pre_esmn = $registro[12];
                $pre_CodigoRENAES = $registro[13];
                $pre_IdEstado = $registro[14];
                $PRE_IDRED = $registro[15];
                $PRE_IDMICRORED = $registro[16];
                $PRE_INSTITUCION = $registro[17];
                $pre_DigitaAtenciones = $registro[18];
                $establecimiento = Establecimiento::firstOrNew(['pre_CodigoRENAES' => $pre_CodigoRENAES]);
                if (!$establecimiento->exists){
                    $establecimiento->codigo = str_replace('"', '', $pre_IdEESS);
                    $establecimiento->nombre = $pre_Nombre;
                    $establecimiento->pre_CodigoRENAES = $pre_CodigoRENAES;
                    $establecimiento->save();
                }
            }
            $firstLine = false;
            $progressBar->advance();
        }

    }
}
