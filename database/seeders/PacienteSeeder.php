<?php

namespace Database\Seeders;

use App\Imports\PacienteImports;
use App\Models\Paciente;
use App\Models\Sexo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //--------------------PRIMERA IMPORTACION----------------------------


        // $this->command->getOutput()->writeln('Iniciando Importación de Pacientes...');
        // $csvFile2 = fopen(base_path('archivos/atenciones.csv'), 'r');
        // $this->command->getOutput()->writeln("Importando Datos... ");
        // $firstLine = true;
        // while(($fila = fgetcsv($csvFile2, 3000, ",")) !== false) {
        //     if(!$firstLine)
        //     {
        //         $registro = explode(";",(string)$fila[0]);
        //         $nroDocumento = str_replace('"', "", $registro[17]);
        //         $paciente = Paciente::firstOrNew(['nro_documento' => $nroDocumento]);
        //         if (!$paciente->exists) {
        //             $paciente->tipo_documento_id = str_replace('"', '', $registro[16]);
        //             $paciente->ape_paterno = str_replace('"', "", $registro[26]);
        //             $paciente->ape_materno = str_replace('"', "", $registro[27]);
        //             $paciente->primer_nombre = str_replace('"', "", $registro[28]);
        //             $paciente->segundo_nombre = str_replace('"', "", $registro[29]);
        //             $paciente->fecha_nacimiento = str_replace('"', "", $registro[30]);
        //             $paciente->sexo_id = Sexo::where('codigo', str_replace('"', '', $registro[31]))->value('id');
        //             $paciente->save();
        //         }
        //     }
        //     $firstLine = false;
        // }



        //$csvFile = fopen(base_path('archivos/minsa/2021.xlsb'), 'r');

        //$this->command->getOutput()->writeln(base_path('archivos/minsa/2021.xlsb'));

        //Excel::import(new PacienteImports, base_path('archivos/minsa/pacientes_sacados_de_ins.xls'));
        
        Excel::import(new PacienteImports, base_path('archivos/minsa/importar_pacientes.xls'));

        // Excel::import(new PacienteImports, base_path('archivos/minsa/pac_2022.xls'));        


    }
}
