<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            UserSeeder::class,
            SexoSeeder::class,
            TipoDocumentoSeeder::class,
            GrupoMenuSeeder::class,
            MenuSeeder::class,
            PacienteSeeder::class,
            ComponenteSeeder::class,
            CondicionMaternaSeeder::class,
            DestinoAseguradoSeeder::class,
            EstablecimientoSeeder::class,
            GrupoEtareoSeeder::class,
            GrupoRiesgoSeeder::class,
            OrigenPersonalSeeder::class,
            ProfesionalSeeder::class,
            ServicioSeeder::class,
            TipoAtencionSeeder::class,
            TipoFormatoSeeder::class,
            PeriodoSeeder::class,
            ModalidadAtencionSeeder::class,
            SupervisionSeeder::class,
            AtencionSeeder::class,
            DiagnosticoSeeder::class,
            TipoIngresoEgresoSeeder::class,
            TipoDiagnosticoSeeder::class,
            AtencionDiagnosticoSeeder::class,
            MedicamentoSeeder::class,
            InsumoSeeder::class,
            ProcedimientoSeeder::class,
            AtencionMedicamentoSeeder::class,
            AtencionInsumoSeeder::class,
            AtencionProcedimientoSeeder::class,
            PrecioMedicamentoSeeder::class,
        ]);
    }
}
