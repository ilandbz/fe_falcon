<?php

namespace Database\Seeders;

use App\Models\TipoIngresoEgreso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoIngresoEgresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['codigo'=>'E' ,'descripcion' => 'Subsidiado'],
            ['codigo'=>'I' ,'descripcion' => 'SemiSubsidiado'],
            ['codigo'=>'T' ,'descripcion' => 'Todos'],
        ];
        foreach($tipos as $row){
            TipoIngresoEgreso::firstOrCreate($row);
        }
    }
}
