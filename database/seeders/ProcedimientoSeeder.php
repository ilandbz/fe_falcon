<?php

namespace Database\Seeders;

use App\Models\Procedimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcedimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $csvFile = fopen(base_path('archivos/procedimientos.csv'), 'r');
        // $nro_registros = -1;
        // while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
        //     $nro_registros +=1;
        // }
        // fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de procedimientos...');
        // $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/procedimientos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        // $progressBar->start();
        $firstLine = true;
        while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                $codigo = str_replace('"', '', $registro[0]); 
                //$this->command->getOutput()->writeln("codigo : ".$codigo);
                $procedimiento = Procedimiento::firstOrNew(['PRCD_ID_PROCEDIMIENTO' => $codigo]);
                if (!$procedimiento->exists) {
                    $procedimiento->PRCD_ID_PROCEDIMIENTO = $codigo;
                    $procedimiento->PRCD_V_CODPRO_MINSA = str_replace('"', '', $registro[1]);
                    $procedimiento->PRCD_V_CODPROCEDIMIENTO = str_replace(['"',','], '', $registro[2]);
                    $procedimiento->PRCD_V_DESPROCEDIMIENTO = str_replace(['"',','], '', $registro[3]);
                    $procedimiento->PRCD_I_ESTADO = str_replace('"', '', $registro[4]);
                    $procedimiento->PRCD_D_FECBAJA = str_replace('"', '', $registro[5]) == '' ? NULL : str_replace('"', '', $registro[5]);
                    $procedimiento->PRCD_V_CODSEG = str_replace('"', '', $registro[6]);
                    $procedimiento->PRCD_V_CODGRU = str_replace('"', '', $registro[7]);
                    $procedimiento->PRCD_V_CODSUB = str_replace('"', '', $registro[8]);
                    $procedimiento->PRCD_V_DOCUMENTO = str_replace('"', '', $registro[9]);
                    $procedimiento->PRCD_I_IDUSUARIOCREA = str_replace('"', '', $registro[10]);
                    $procedimiento->PRCD_D_FECCREA = str_replace('"', '', $registro[11]);
                    $procedimiento->PRCD_V_DOCUMENTOCREA = str_replace('"', '', $registro[12]);
                    $procedimiento->PRCD_I_IDUSUARIOACT = str_replace('"', '', $registro[13]);
                    $procedimiento->PRCD_D_FECACT = str_replace('"', '', $registro[14]) == '' ? NULL : str_replace('"', '', $registro[14]);
                    $procedimiento->PRCD_V_DOCUMENTOACT = str_replace('"', '', $registro[15]);
                    $procedimiento->PRCD_B_FLAGREGISTROELIMINADO = str_replace('"', '', $registro[16]);
                    $procedimiento->PRCD_C_CONDICION = str_replace('"', '', $registro[17]);
                    $procedimiento->PRCD_V_TIPORESULTADO = str_replace('"', '', $registro[18]);
                    $procedimiento->PRCD_V_CODPROCEDIMEQUIVALEN = str_replace('"', '', $registro[19]);
                    $procedimiento->save();
                    $this->command->getOutput()->writeln('indice REGISTRADO : '.$firstLine.' ID : '.$codigo);
                }
                // Procedimiento::firstOrCreate([
                //     'PRCD_ID_PROCEDIMIENTO' => str_replace('"', '', $codigo),
                //     'PRCD_V_CODPRO_MINSA' => str_replace('"', '', $registro[1]),
                //     'PRCD_V_CODPROCEDIMIENTO' => str_replace(['"',','], '', $registro[2]),
                //     'PRCD_V_DESPROCEDIMIENTO' => str_replace(['"',','], '', $registro[3]),
                //     'PRCD_I_ESTADO' => str_replace('"', '', $registro[4]),
                //     'PRCD_D_FECBAJA' => str_replace('"', '', $registro[5]) == '' ? NULL : str_replace('"', '', $registro[5]),
                //     'PRCD_V_CODSEG' => str_replace('"', '', $registro[6]),
                //     'PRCD_V_CODGRU' => str_replace('"', '', $registro[7]),
                //     'PRCD_V_CODSUB' => str_replace('"', '', $registro[8]),
                //     'PRCD_V_DOCUMENTO' => str_replace('"', '', $registro[9]),
                //     'PRCD_I_IDUSUARIOCREA' => str_replace('"', '', $registro[10]),
                //     'PRCD_D_FECCREA' => str_replace('"', '', $registro[11]),
                //     'PRCD_V_DOCUMENTOCREA' => str_replace('"', '', $registro[12]),
                //     'PRCD_I_IDUSUARIOACT' => str_replace('"', '', $registro[13]),
                //     'PRCD_D_FECACT' => str_replace('"', '', $registro[14]) == '' ? NULL : str_replace('"', '', $registro[14]),
                //     'PRCD_V_DOCUMENTOACT' => str_replace('"', '', $registro[15]),
                //     'PRCD_B_FLAGREGISTROELIMINADO' => str_replace('"', '', $registro[16]),
                //     'PRCD_C_CONDICION' => str_replace('"', '', $registro[17]),
                //     'PRCD_V_TIPORESULTADO' => str_replace('"', '', $registro[18]),
                //     'PRCD_V_CODPROCEDIMEQUIVALEN' => str_replace('"', '', $registro[19]),
                // ]);
                // $progressBar->advance();
            }
            $firstLine = false;
        }
    }
}
