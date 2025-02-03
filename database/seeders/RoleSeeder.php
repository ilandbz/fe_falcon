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
        $roles = [
            'Super Usuario',
            'Operaciones',
            'Cobranza',
            'Cobranza Huanuco',
            'Asesor',
            'Cliente',
            'Gerente Zonal',
            'Gerente Agencia',
            'Gestor de Cobranza',
            'Invitado',
        ];
        
        foreach ($roles as $role) {
            Role::firstOrCreate(['nombre' => mb_strtoupper($role)]);
        }
    }
}
