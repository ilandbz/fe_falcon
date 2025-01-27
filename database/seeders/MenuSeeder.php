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
                'grupo_id'  => GrupoMenu::where('titulo', 'Sistema')->value('id'),
                'orden' => 5,
            ],
            [
                'nombre' => 'Menús',
                'slug' => 'gestion-menus',
                'icono' => 'fas fa-list',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Sistema')->value('id'),
                'orden' => 6,
            ],
            //Sistem
            [
                'nombre' => 'Pacientes',
                'slug' => 'gestion-pacientes',
                'icono' => 'fas fa-person-booth',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 7,
            ],
            [
                'nombre' => 'Medicina',
                'slug' => 'gestion-medicina',
                'icono' => 'fas fa-flask',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Servicios',
                'slug' => 'gestion-servicios',
                'icono' => 'fas fa-medkit',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Procedimientos',
                'slug' => 'gestion-procedimientos',
                'icono' => 'fas fa-hospital-symbol',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Insumo',
                'slug' => 'gestion-insumos',
                'icono' => 'fas fa-box',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ], 
            [
                'nombre' => 'Atencion',
                'slug' => 'gestion-atencion',
                'icono' => 'fas fa-bell',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ],                             
            [
                'nombre' => 'Diagnostico',
                'slug' => 'gestion-diagnostico',
                'icono' => 'fas fa-stethoscope',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ], 
            [
                'nombre' => 'Establecimientos',
                'slug' => 'establecimiento',
                'icono' => 'fas fa-store',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Configuraciones')->value('id'),
                'orden' => 8,
            ],             
            [
                'nombre' => 'Medicamentos',
                'slug' => 'reporte-medicamentos',
                'icono' => 'fas fa-flask',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Precios Por Periodo')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Insumos',
                'slug' => 'reporte-insumo',
                'icono' => 'fas fa-box',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Precios Por Periodo')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Procedimientos',
                'slug' => 'reporte-procedimiento',
                'icono' => 'fas fa-box',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Precios Por Periodo')->value('id'),
                'orden' => 8,
            ],                       
            [
                'nombre' => 'Servicios',
                'slug' => 'reporte-servicio',
                'icono' => 'fas fa-medkit',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Precios Por Periodo')->value('id'),
                'orden' => 8,
            ], 
            [
                'nombre' => 'Produccion FUAS',
                'slug' => 'reporte-produccion',
                'icono' => 'fas fa-cube',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Reportes')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Minsa',
                'slug' => 'fuas-observadas',
                'icono' => 'fas fa-exclamation-triangle',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Reportes')->value('id'),
                'orden' => 8,
            ],     
            [
                'nombre' => 'Produccion Bruta y Neta',
                'slug' => 'produccion-bruta-neta',
                'icono' => 'fas fa-file-alt',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Reportes')->value('id'),
                'orden' => 8,
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
