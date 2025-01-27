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
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->dropForeign('minsa_medicamentos_servicio_id_foreign');
        });

        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->dropColumn('servicio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->foreignId('servicio_id')->constrained('diagnosticos')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
