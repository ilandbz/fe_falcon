<?php

namespace Database\Seeders;

use App\Models\Agencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencias = [
            [
                'id'    => 1,
                'nombre' => 'HUANUCO',
                'direccion' => 'Jr. Tarapaca 591',
                'telefono' => '062-286809',
            ],
            [
                'id'    => 2,
                'nombre' => 'TINGO MARIA',
                'direccion' => 'Jr. Tito Jaime 697',
                'telefono' => '062-797215',
            ],
            [
                'id'    => 3,
                'nombre' => 'HUANUCO2',
                'direccion' => 'Jr. Tarapaca 591',
                'telefono' => '062-612543',
            ],
            [
                'id'    => 4,
                'nombre' => 'PANAO',
                'direccion' => 'Calle Lima 031',
                'telefono' => '932052255',
            ],
        ];

        foreach($agencias as $registro){
            Agencia::updateOrCreate(
                ['id' => $registro['id']],  // Buscar por ID
                $registro                   // Datos para actualizar o crear
            );
        }
    }
}
