<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();

            $table->string('med_CodMed', 13);
            $table->string('med_Nombre', 200);
            $table->string('med_FormaFarmaceutica', 15)->nullable();
            $table->string('med_Presen', 20);
            $table->string('med_Concen', 103)->nullable();
            $table->decimal('med_Costo', 11, 2)->default('0.00');
            $table->char('med_Petitorio', 1);
            $table->string('med_Petitorio2005', 6);
            $table->string('med_Petitorio2010', 6);
            $table->date('med_FecBaja')->nullable();
            $table->string('med_FFDigemid', 100)->nullable();
            $table->string('MED_V_NOMBRE_SIS', 150)->nullable();
            $table->string('MED_V_PRESENT_SIS', 50)->nullable();
            $table->string('MED_V_FORMAFARM_SIS', 15)->nullable();
            $table->string('MED_V_UNIDAD_CONSUMO', 50)->nullable();
            $table->decimal('MED_N_FACTOR_CONSUMO', 12, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
