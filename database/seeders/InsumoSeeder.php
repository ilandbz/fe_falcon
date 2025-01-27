<?php

namespace Database\Seeders;

use App\Imports\InsumoSheetImport;
use App\Models\Atencion;
use App\Models\Insumo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
class InsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Excel::import(new InsumoSheetImport, base_path('archivos/datos_arfsisweb/insumos.xml'));


        $this->command->getOutput()->writeln('Iniciando Importación de insumos...');
        $csvFile2 = fopen(base_path('archivos/resultados_fec_trans_nulos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $i=0;
        while(($fila = fgetcsv($csvFile2, 1000, "{")) !== false) {
            $registro = explode(",",(string)$fila[0]);
            $codigo = $registro[0]; 
            $this->command->getOutput()->writeln('indice : '.$i.' CODIGO : '.$codigo);
            $fecha = str_replace('"', '', $registro[3]); 
            $atencion = Atencion::where('codigo', $codigo)->first();
            $atencion->fechatrans           = $fecha;
            $atencion->save();
            $this->command->getOutput()->writeln('indice : '.$i.' CODIGO : '.$codigo. ' FECHA '.$fecha);
            $i+=1;
        }



        // // $csvFile = fopen(base_path('archivos/insumos.csv'), 'r');
        // // $nro_registros = -1;
        // // while (($datum = fgetcsv($csvFile, 1000, '{')) !== false){
        // //     $nro_registros +=1;
        // // }
        // // fclose($csvFile);
        // $this->command->getOutput()->writeln('Iniciando Importación de insumos...');
        // // $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        // $csvFile2 = fopen(base_path('archivos/insumos.csv'), 'r');
        // $this->command->getOutput()->writeln("Importando Datos... ");
        // // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        // // $progressBar->start();
        // $firstLine = true;
        // while(($fila = fgetcsv($csvFile2, 2000, "{")) !== false) {
        //     if(!$firstLine)
        //     {
        //         $registro = explode(";",(string)$fila[0]);
        //         $codigo = $registro[0]; 
        //         //$this->command->getOutput()->writeln('CODIGO: '.$codigo);
        //         Insumo::firstOrCreate([
        //             'ins_CodIns' => str_replace('"', '', $codigo),
        //             'ins_Nombre' => str_replace('"', '', $registro[1]),
        //             'ins_FormaFarmaceutica' => str_replace('"', '', $registro[2]),
        //             'ins_Presen' => str_replace(['"', ','], ['','.'], $registro[3]),
        //             'ins_Concen' => str_replace('"', '', $registro[4]),
        //             'ins_Costo' => str_replace('"', '', $registro[5]),
        //             'ins_Observacion' => str_replace('"', '', $registro[6]),
        //             'ins_Petitorio' => str_replace('"', '', $registro[7]),
        //             'ins_FecBaja' => str_replace('"', '', $registro[8])=='' ? NULL : str_replace('"', '', $registro[8]),
        //             'ins_DocBaja' => str_replace('"', '', $registro[9])=='' ? NULL : str_replace('"', '', $registro[9]),
        //             'INSU_V_NOMBRE_SIS' => str_replace('"', '', $registro[11]),
        //             'INSU_V_PRESENT_SIS' => str_replace(['"', ','], ['','.'], $registro[12]),
        //             'INSU_V_FORMAFARM_SIS' => str_replace('"', '', $registro[13]),
        //             'INSU_V_UNIDAD_CONSUMO' => str_replace('"', '', $registro[14]),
        //             'INSU_N_FACTOR_CONSUMO' => str_replace('"', '', $registro[15]),
        //         ]);
        //         $this->command->getOutput()->writeln('indice REGISTRADO : '.$firstLine.' ID : '.$codigo);                
        //         //usleep(1000);
        //         //$progressBar->advance();
        //     }
        //     $firstLine = false;
        //}
    }
}
