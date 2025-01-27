<?php

namespace Database\Seeders;

use App\Models\OrigenPersonal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrigenPersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origenes = [
            ['descripcion' => 'DEL ESTABLECIMIENTO'],
            ['descripcion' => 'ITINERANTE'],
            ['descripcion' => 'PLAN MAS SALUD'],
            ['descripcion' => 'OFERTA FLEXIBLE'],
            ['descripcion' => 'TELESALUD'],
        ];
        foreach($origenes as $row){
            OrigenPersonal::firstOrCreate($row);
        }

    }
}
