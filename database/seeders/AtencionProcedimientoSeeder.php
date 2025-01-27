<?php

namespace Database\Seeders;

use App\Models\AtencionDiagnostico;
use App\Models\AtencionProcedimiento;
use App\Models\Procedimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtencionProcedimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        set_time_limit(0);
        $this->command->getOutput()->writeln('Iniciando Importación de atencion_procedimientos...');
        $csvFile2 = fopen(base_path('archivos/atencion_procedimientos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $firstLine = 1;
        while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
            //622000
            if($firstLine>=620000)
            {
                $registro = explode(";",(string)$fila[0]);
                $codigo = str_replace('"', '', $registro[0]);
                $atencion_diagnostico_id = AtencionDiagnostico::where('codigo', str_replace('"', '', $registro[1]))->value('id');
                $procedimiento_id = Procedimiento::where('PRCD_V_CODPROCEDIMIENTO', str_replace('"', '', $registro[2]))->value('id');
                $atencionprocedimiento = AtencionProcedimiento::where([
                    'atencion_diagnostico_id' => $atencion_diagnostico_id,
                    'procedimiento_id' => $procedimiento_id
                ])->first();
                if (!$atencionprocedimiento) {
                    AtencionProcedimiento::firstOrCreate([
                        'codigo'    => $codigo,
                        'atencion_diagnostico_id' => $atencion_diagnostico_id,
                        'procedimiento_id' => $procedimiento_id,
                        'apro_CantIndicado' => str_replace('"', '', $registro[3]),
                        'apro_CantEjecutado' => str_replace('"', '', $registro[4]),
                        'precio_unitario' => str_replace('"', '', $registro[5]),
                        'resultado'     => str_replace('"', '', $registro[7]),
                    ]);
                    $this->command->getOutput()->writeln('INDICE REGISTRADO '.$firstLine);
                }
            } 
            $this->command->getOutput()->writeln('INDICE REGISTRADO '.$firstLine); 
            $firstLine += 1;
        }
    }
}
