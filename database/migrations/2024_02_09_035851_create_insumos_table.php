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
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('ins_CodIns', 8);
            $table->string('ins_Nombre', 200);
            $table->string('ins_FormaFarmaceutica', 15);
            $table->string('ins_Presen', 80)->nullable();
            $table->string('ins_Concen', 80)->nullable();
            $table->decimal('ins_Costo', 12, 4);
            $table->string('ins_Observacion', 500)->nullable();
            $table->char('ins_Petitorio', 1)->default('S');
            $table->date('ins_FecBaja')->nullable();
            $table->string('ins_DocBaja', 500)->nullable();
            $table->string('INSU_V_NOMBRE_SIS', 150)->nullable();
            $table->string('INSU_V_PRESENT_SIS', 50)->nullable();
            $table->string('INSU_V_FORMAFARM_SIS', 15)->nullable();
            $table->string('INSU_V_UNIDAD_CONSUMO', 50)->nullable();
            $table->decimal('INSU_N_FACTOR_CONSUMO', 12, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
