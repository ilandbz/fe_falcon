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
                'orden' => 1,
            ],
            [
                'nombre' => 'Menús',
                'slug' => 'gestion-menus',
                'icono' => 'fas fa-list',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuracion')->value('id'),
                'orden' => 2,
            ],
            [
                'nombre' => 'Agencias',
                'slug' => 'gestion-agencias',
                'icono' => 'fas fa-building',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuracion')->value('id'),
                'orden' => 3,
            ],
            
            [
                'nombre' => 'Cliente',
                'slug' => 'gestion-cliente',
                'icono' => 'fas fa-user',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 1,
            ],
            [
                'nombre' => 'Creditos',
                'slug' => 'gestion-creditos',
                'icono' => 'fas fa-hand-holding-usd',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 2,
            ],
            [
                'nombre' => 'Asesor',
                'slug' => 'gestion-asesor',
                'icono' => 'fas fa-user-tie',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 3,
            ],
            [
                'nombre' => 'Pagos',
                'slug' => 'gestion-pagos',
                'icono' => 'fas fa-credit-card',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 4,
            ],
            [
                'nombre' => 'Cobranza Campo',
                'slug' => 'gestion-cobranza-campo',
                'icono' => 'fas fa-map-marked-alt',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 5,
            ],
            [
                'nombre' => 'Desembolso',
                'slug' => 'gestion-desembolso',
                'icono' => 'fas fa-money-bill-wave',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 6,
            ],
            [
                'nombre' => 'Habilitar Asesor',
                'slug' => 'habilitar-asesor',
                'icono' => 'fas fa-user-check',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 7,
            ],
            [
                'nombre' => 'Tickets',
                'slug' => 'gestion-tickets',
                'icono' => 'fas fa-ticket-alt',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Evaluar',
                'slug' => 'evaluar-credito',
                'icono' => 'fa-solid fa-file-circle-check',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Creditos')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Registros',
                'slug' => 'gestion-registros',
                'icono' => 'fas fa-clipboard-list',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Junta')->value('id'),
                'orden' => 1,
            ],
            [
                'nombre' => 'Pagos',
                'slug' => 'gestion-pagos',
                'icono' => 'fas fa-credit-card',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Junta')->value('id'),
                'orden' => 2,
            ],
            [
                'nombre' => 'Cobranza Campo',
                'slug' => 'gestion-cobranza-campo',
                'icono' => 'fas fa-map-marked-alt',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Junta')->value('id'),
                'orden' => 3,
            ],
            [
                'nombre' => 'Devolución',
                'slug' => 'gestion-devolucion',
                'icono' => 'fas fa-undo-alt',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Junta')->value('id'),
                'orden' => 4,
            ],
            [
                'nombre' => 'Evaluar',
                'slug' => 'evaluar-credito-segundo-nivel',
                'icono' => 'fa-solid fa-file-circle-check',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Gerencia Zonal')->value('id'),
                'orden' => 4,
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
