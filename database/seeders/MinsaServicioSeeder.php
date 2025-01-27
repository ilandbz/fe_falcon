<?php

namespace Database\Seeders;

use App\Imports\ServicioImports;
use App\Models\MinsaServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MinsaServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ServicioImports, base_path('archivos/minsa/serv_2023.xls'));

    }
}
