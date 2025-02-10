<?php

namespace Database\Seeders;

use App\Models\Profesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profesiones = [
            'Administración de Empresas',
            'Ingeniería Industrial',
            'Ingenieria de Sistemas',
            'Contabilidad',
            'Economía',
            'Administración de Negocios Internacionales',
            'Derecho',
            'Ciencias de la Comunicación',
            'Marketing',
            'Psicología',
            'Licenciatura',
        ];
        foreach ($profesiones as $profesion) {
            Profesion::create([
                'nombre' => $profesion,
            ]);
        }
    }




}
