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
        $user = User::firstOrNew(['name' => 'ilandbz']);
        if (!$user->exists) {
            $user->password = Hash::make('123456');
            $user->role_id = Role::where('nombre', 'Super Usuario')->value('id');
            $user->save();
        }

        $adminUser = User::firstOrNew(['name' => 'KESPIRITU']);
        
        if (!$adminUser->exists) {
            $adminUser->password = Hash::make('123456');
            $adminUser->role_id = Role::where('nombre', 'Operaciones')->value('id');
            $adminUser->save();
        }
    }
}