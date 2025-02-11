<?php

namespace Database\Seeders;

use App\Models\Agencia;
use App\Models\Credito;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/solicitud.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Creditos...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Creditos... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/solicitud.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $cliente = Credito::firstOrCreate(
                ['id' => $idsolicitud],
                [
                    'cliente_id'     => $codcliente,
                    'agencia_id'     => Agencia::where('nombre',$agencia)->value('id'),
                    'asesor_id'      => User::where('name', $idasesor)->value('id'),
                    'estado'         => $estado,
                    'fecha_reg'      => $fecha_reg,
                    'tipo'           => $tipo,
                    'monto'          => $monto,
                    'producto'       => $producto,
                    'frecuencia'     => $frecuencia,
                    'plazo'          => $plazo,
                    'medioorigen'    => $medioorigen,
                    'dondepagara'    => $dondepagara,
                    'fuenterecursos' => $fuenterecursos,
                    'tasainteres'    => $tasainteres ?? 0.00,
                    'total'          => $total ?? 0.00,
                    'costomora'      => $costomora ?? 0.00,
                ]
            );                   
            //usleep(1000);
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
