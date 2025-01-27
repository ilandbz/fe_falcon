<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->dropForeign('minsa_insumos_servicio_id_foreign');
            $table->dropForeign('minsa_insumos_diagnostico_id_foreign');
        });

        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->dropColumn('servicio_id');
            $table->dropColumn('diagnostico_id');
            $table->string('periodo', 6);
            $table->dropUnique(['fua']);
            $table->dropColumn('fiss_alDiag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade')->onUpdate('cascade');
        });
        
        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->dropColumn('periodo');
            $table->unique(['fua']);
            $table->string('fiss_alDiag')->nullable();
        });
    }
};
