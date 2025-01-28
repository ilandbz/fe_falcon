<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate([ 'nombre' => 'Super Usuario']);
        Role::firstOrCreate([ 'nombre' => 'Operaciones']);
        Role::firstOrCreate([ 'nombre' => 'Cobranza']);
        Role::firstOrCreate([ 'nombre' => 'Asesor']);
        Role::firstOrCreate([ 'nombre' => 'Cliente']);
        Role::firstOrCreate([ 'nombre' => 'Gerente Zonal']);
        Role::firstOrCreate([ 'nombre' => 'Gerente Agencia']);
    }
}
