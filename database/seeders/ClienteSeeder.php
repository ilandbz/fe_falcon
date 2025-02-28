<?php

namespace Database\Seeders;

use App\Models\Agencia;
use App\Models\Cliente;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/cliente.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Clientes...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Clientes... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/cliente.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $cliente = Cliente::firstOrCreate(
                ['id' => $codcliente],
                [
                    'persona_id' => Persona::where('dni', $dni)->value('id'),
                    'usuario_id' => User::where('name', $idasesor)->value('id'),
                    'agencia_id' => Agencia::where('nombre',$agencia)->value('id'),
                    'dniaval' => $dniaval,
                    'estado' => $estado,
                    'fecha_reg' => $fecha_reg,
                    'hora_reg' => $hora_reg,
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
