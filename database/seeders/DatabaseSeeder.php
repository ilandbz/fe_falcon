<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Agencia;
use App\Models\GrupoMenu;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AgenciaSeeder::class,
            UserSeeder::class,
            GrupoMenuSeeder::class,
            MenuSeeder::class,
            UbigeoSeeder::class,
        ]);
    }
}
