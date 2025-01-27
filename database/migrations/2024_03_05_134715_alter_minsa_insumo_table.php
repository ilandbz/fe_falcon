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
        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->unique(['fua', 'insumo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->dropUnique(['fua', 'insumo_id']);
        });
    }
};
