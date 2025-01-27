<?php

namespace Database\Seeders;

use App\Imports\InsumosPorProcedimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
class InsumoProcedimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new InsumosPorProcedimiento, base_path('archivos/cmps_insumos.xlsx'));
    }
}
