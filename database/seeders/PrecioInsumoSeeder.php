<?php

namespace Database\Seeders;

use App\Models\Insumo;
use App\Models\PrecioInsumo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrecioInsumoSeeder extends Seeder
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
            // '202302',
            // '202303',
            // '202304',
            // '202305',
            '202306',
        ];
        foreach($periodos as $period){
            // $csvFile = fopen(base_path('archivos/tarifario/'.$period.'.csv'), 'r');
            // $nro_registros = -1;
            // while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
            //     $nro_registros +=1;
            // }
            // fclose($csvFile);
            $this->command->getOutput()->writeln('Iniciando Importación de '.$period.'...');
            // $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
            $csvFile2 = fopen(base_path('archivos/tarifario/'.$period.'.csv'), 'r');
            $this->command->getOutput()->writeln("Importando Datos... ");
            // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
            // $progressBar->start();
            $firstLine = 1;
            while(($fila = fgetcsv($csvFile2, 2000, ";")) !== false) {
                if($firstLine==20000)
                {
                    $registro = explode(",",(string)$fila[0]);
                    $insumoId = Insumo::where('ins_CodIns', str_replace(['"', ' ', "'"], '', $registro[2]))->value('id');
                    $precioinsumo = PrecioInsumo::where([
                        'CPERIODO' => $period,
                        'insumo_id' => $insumoId
                    ])->first();
                    if (!$precioinsumo) {
                        if ($insumoId) {
                            PrecioInsumo::firstOrCreate([
                                'CPERIODO'      => str_replace(['"', ' '], '', $registro[0]),
                                'CCODUE'        => str_replace(['"', ' '], '', $registro[1]),
                                'insumo_id'     => $insumoId,
                                'TIPOCOMP'      => str_replace(['"', ' '], '', $registro[3]),
                                'PREADJ'        => str_replace(['"', ' '], '', $registro[4]),
                                'PREOPE'        => str_replace(['"', ' '], '', $registro[5]),
                                'CODIGO_SIGA'   => str_replace(['"', ' '], '', $registro[8]),
                            ]);
                            $this->command->getOutput()->writeln('indice REGISTRADO : '.$firstLine.' PERIODO : '.$period);
                        }
                        
                    }
                    // $progressBar->advance();
                }
                $firstLine+=1;
            }
        }
    }
}
