<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('minsa_procedimientos', function (Blueprint $table) {
            $table->unique(['fua', 'procedimiento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minsa_procedimientos', function (Blueprint $table) {
            $table->dropUnique(['fua', 'procedimiento_id']);
        });
    }
};
