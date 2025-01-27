<?php

namespace Database\Seeders;

use App\Models\Medicamento;
use App\Models\PrecioMedicamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrecioMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodos = [
            // '202205',
            // '202206',
            // '202207',
            // '202208',
            // '202209',
            // '202210',
            // '202211',
            // '202212',
            // '202301',
            '202302',
            '202303',
            '202304',
            '202305',
            '202306',
        ];
        foreach($periodos as $period){
            $this->command->getOutput()->writeln('Iniciando Importación de '.$period.'...');
            $csvFile2 = fopen(base_path('archivos/tarifario/'.$period.'.csv'), 'r');
            $firstLine = 1;
            while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
                if($firstLine>=4)
                {
                    $registro = explode(",",(string)$fila[0]);
                    $codmed=str_replace(['"', ' ', "'"], '', $registro[2]);
                    if($registro[0]==''){
                        break;
                    }
                    $periodo=str_replace(['"', ' '], '', $registro[0]);
                    $medicamentoId = Medicamento::where('med_CodMed', $codmed)->value('id');
                    $preciomedicamento = PrecioMedicamento::where([
                        'CPERIODO' => $period,
                        'medicamento_id' => $medicamentoId
                    ])->first();
                    if (!$preciomedicamento) {
                        if ($medicamentoId) {
                            PrecioMedicamento::firstOrCreate([
                                'CPERIODO'      => $periodo,
                                'CCODUE'        => str_replace(['"', ' '], '', $registro[1]),
                                'medicamento_id'=> $medicamentoId,
                                'TIPOCOMP'      => str_replace(['"', ' '], '', $registro[3]),
                                'PREADJ'        => str_replace(['"', ' '], '', $registro[4]),
                                'PREOPE'        => str_replace(['"', ' '], '', $registro[5]),
                                'CODIGO_SIGA'   => str_replace(['"', ' '], '', $registro[8]),
                            ]);
                            $this->command->getOutput()->writeln('indice REGISTRADO : '.$firstLine.' PERIODO : '.$period);
                        }
                    }
                }
                $firstLine+=1;
            }
        }
        
    }
}
