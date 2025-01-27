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
            $table->dropColumn('fiss_alDiag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->foreignId('fiss_alDiag')->constrained('diagnosticos')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
