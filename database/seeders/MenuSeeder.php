<?php

namespace Database\Seeders;

use App\Models\GrupoMenu;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('nombre', 'Super Usuario')->first(); 

        $menuspadres = [ 
            //Sistem
            [
                'nombre' => 'Usuarios',
                'slug' => 'gestion-usuarios',
                'icono' => 'fas fa-user-friends',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuracion')->value('id'),
                'orden' => 5,
            ],
            [
                'nombre' => 'Menús',
                'slug' => 'gestion-menus',
                'icono' => 'fas fa-list',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuracion')->value('id'),
                'orden' => 6,
            ],
        ];
        $menuIds = [];
        foreach($menuspadres as $row){
            $menu = Menu::firstOrCreate($row);
            $menuIds[] = $menu->id;
        }
        $role->menus()->sync($menuIds);
    }
}
