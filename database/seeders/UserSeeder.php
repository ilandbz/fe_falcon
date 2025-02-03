<?php

namespace Database\Seeders;

use App\Models\Agencia;
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


        // $roleIds = Role::pluck('id');
        // $superusuario->roles()->sync($roleIds);
        

        $usuarios = [

            [
                'name' => 'KESPIRITU', 
                'dni' => '44992550', 
                'roles' => [
                    'Operaciones',
                    'Cobranza Huanuco',
                    'Gerente Agencia',
                ],
                'agencias' => [
                    'Huanuco',
                    'Tingo Maria',
                    'Huánuco 2',
                    'Panao',
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
        
            $roleIds = Role::whereIn('nombre', $usuario['roles'])->pluck('id');
            $agenciaIds = Agencia::whereIn('nombre', $usuario['agencias'])->pluck('id');
            $user->roles()->sync($roleIds);
            $user->agencias()->sync($agenciaIds);
        }



    }
}