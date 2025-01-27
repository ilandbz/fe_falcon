<?php

namespace Database\Seeders;

use App\Models\AtencionDiagnostico;
use App\Models\AtencionMedicamento;
use App\Models\Medicamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtencionMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/atencion_medicamentos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, ',')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de atencion_medicamentos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/atencion_medicamentos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        while(($fila = fgetcsv($csvFile2, 2000, ",")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                $atencionmedicamento = AtencionMedicamento::firstOrNew(['codigo' => $registro[0]]);
                if (!$atencionmedicamento->exists) {
                    $atencionmedicamento->codigo    = str_replace('"', '', $registro[0]);
                    $atencionmedicamento->atencion_diagnostico_id = AtencionDiagnostico::where('codigo', str_replace('"', '', $registro[1]))->value('id');
                    $atencionmedicamento->medicamento_id = Medicamento::where('med_CodMed', str_replace('"', '', $registro[2]))->value('id');
                    $atencionmedicamento->cantidad_preescrita = str_replace('"', '', $registro[3]);
                    $atencionmedicamento->cantidad_entregada = str_replace('"', '', $registro[4]);
                    $atencionmedicamento->precio_unitario = str_replace('"', '', $registro[5]);
                }
                // AtencionMedicamento::firstOrCreate([
                //     'codigo'    => str_replace('"', '', $registro[0]),
                //     'atencion_diagnostico_id' => AtencionDiagnostico::where('codigo', str_replace('"', '', $registro[1]))->value('id'),
                //     'medicamento_id' => Medicamento::where('med_CodMed', str_replace('"', '', $registro[2]))->value('id'),
                //     'cantidad_preescrita' => str_replace('"', '', $registro[3]),
                //     'cantidad_entregada' => str_replace('"', '', $registro[4]),
                //     'precio_unitario' => str_replace('"', '', $registro[5]),
                // ]);
                $progressBar->advance();
            }
            $firstLine = false;
        }
    }
}
