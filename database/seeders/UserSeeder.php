<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superusuario = User::firstOrCreate([
            'name' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        $roleId = Role::where('nombre', 'Super Usuario')->value('id');

        $superusuario->roles()->sync([$roleId]);

        $usuarios = [
            [
                'name' => 'KESPIRITU', 
                'dni' => '44992550', 
                'roles' => [
                    'Operaciones',
                    'Cobranza Huanuco',
                    'Gerente Agencia'
                ],
            ],
        ];
        
        foreach ($usuarios as $usuario) {
            $user = User::firstOrCreate(
                [
                    'name' => $usuario['name'],
                    'dni' => $usuario['dni'],
                    'password' => Hash::make($usuario['dni']),
                ]
            );
        
            // Obtener IDs de los roles en una sola consulta
            $roleIds = Role::whereIn('nombre', $usuario['roles'])->pluck('id');
        
            // Asignar roles al usuario
            $user->roles()->sync($roleIds);
        }

    }
}