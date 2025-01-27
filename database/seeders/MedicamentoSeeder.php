<?php

namespace Database\Seeders;

use App\Models\Medicamento;
use App\Imports\Medicamentos_imports;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class MedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new Medicamentos_imports, base_path('archivos/datos_arfsisweb/medicamentos.xml'));
        // $csvFile = fopen(base_path('archivos/medicamentos.csv'), 'r');
        // $nro_registros = -1;
        // while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
        //     $nro_registros +=1;
        // }
        // fclose($csvFile);
        // $this->command->getOutput()->writeln('Iniciando Importación de medicamentos...');
        // $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        // $csvFile2 = fopen(base_path('archivos/medicamentos.csv'), 'r');
        // $this->command->getOutput()->writeln("Importando Datos... ");
        // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        // $progressBar->start();
        // $firstLine = true;
        // while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
        //     if(!$firstLine)
        //     {

        //         $registro = explode(";",(string)$fila[0]);
        //         $codigo = $registro[0]; 
        //         $medicamento = Medicamento::firstOrNew(['med_CodMed' => $codigo]);
        //         if (!$medicamento->exists) {
        //             $medicamento->med_CodMed = str_replace('"', '', $codigo);
        //             $medicamento->med_Nombre = str_replace('"', '', $registro[1]);
        //             $medicamento->med_FormaFarmaceutica = str_replace(['"', ','], ['', ' '], $registro[2]);
        //             $medicamento->med_Presen = str_replace('"', '', $registro[3]);
        //             $medicamento->med_Concen = str_replace('"', '', $registro[4]);
        //             $medicamento->med_Costo = str_replace('"', '', $registro[5]);
        //             $medicamento->med_Petitorio = str_replace('"', '', $registro[6]);
        //             $medicamento->med_Petitorio2005 = str_replace('"', '', $registro[7]);
        //             $medicamento->med_Petitorio2010 = str_replace('"', '', $registro[8]);
        //             $medicamento->med_FecBaja = str_replace('"', '', $registro[9]) == '' ? NULL : str_replace('"', '', $registro[9]);
        //             $medicamento->med_FFDigemid = str_replace('"', '', $registro[10]) == '' ? NULL : str_replace('"', '', $registro[10]);
        //             $medicamento->MED_V_NOMBRE_SIS = str_replace('"', '', $registro[12]);
        //             $medicamento->MED_V_PRESENT_SIS = str_replace('"', '', $registro[13]);
        //             $medicamento->MED_V_FORMAFARM_SIS = str_replace('"', '', $registro[14]);
        //             $medicamento->MED_V_UNIDAD_CONSUMO = str_replace('"', '', $registro[15]);
        //             $medicamento->MED_N_FACTOR_CONSUMO = str_replace('"', '', $registro[16]);
        //             $medicamento->save();
        //         }
        //         $progressBar->advance();
        //     }
        //     $firstLine = false;
        // }
    }
}
