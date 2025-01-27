<?php

namespace Database\Seeders;

use App\Models\Supervision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supervisiones = [
            ['descripcion' => 'Aprobado'],
            ['descripcion' => 'Rechazado Conforme'],
            ['descripcion' => 'Rechazado No Conforme'],
        ];
        foreach($supervisiones as $row){
            Supervision::firstOrCreate($row);
        }
    }
}
