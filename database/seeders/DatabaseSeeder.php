<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Agencia;
use App\Models\CreditosCancelar;
use App\Models\GrupoMenu;
use App\Models\Menu;
use App\Models\TipoGerente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // FeriadoSeeder::class,
            // RoleSeeder::class,
            // AgenciaSeeder::class,
            // GrupoMenuSeeder::class,
            // MenuSeeder::class,
            // UbigeoSeeder::class,
            // UbicacionSeeder::class,
            // PersonaSeeder::class,
            // ConyugueSeeder::class,
            // UserSeeder::class,
            // TipoEntidadSeeder::class,
            // TipoGerenteSeeder::class,
            // TipoActivoSeeder::class,
            // TipoActividadSeeder::class,
            // ProfesionSeeder::class,
            // ClienteSeeder::class,
            // CreditoSeeder::class,
            // DesembolsoSeeder::class,
            // DetCalendarioPagosSeeder::class,
            // CreditosCancelarSeeder::class,
            // KardexCreditoSeeder::class,
            AnalisisCualitativoSeeder::class,
            BalanceSeeder::class,
            PerdidaGananciaSeeder::class,
            PropuestaCreditoSeeder::class,
            DetBalanceSeeder::class,
            // CostoMoraSeeder::class,           
            // SeguroDesgravamenSeeder::class,
        ]);
    }
}
