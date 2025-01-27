<?php

namespace Database\Seeders;

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
            $user->role_id = 1;
            $user->save();
        }

        $adminUser = User::firstOrNew(['name' => 'admin']);
        
        if (!$adminUser->exists) {
            $adminUser->password = Hash::make('123456');
            $adminUser->role_id = 1;
            $adminUser->save();
        }
    }
}
