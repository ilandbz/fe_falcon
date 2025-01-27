<?php

namespace Database\Seeders;

use App\Models\CondicionMaterna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CondicionMaternaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $condiciones = [
            ['codigo' => '0','descripcion' => 'No Gestante'],
            ['codigo' => '1','descripcion' => 'Gestante'],
            ['codigo' => '2','descripcion' => 'Puerpera'],
            ['codigo' => '3','descripcion' => 'Todos'],
        ];
        foreach($condiciones as $row){
            CondicionMaterna::firstOrCreate($row);
        }

    }
}
