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
        Schema::table('minsa_procedimientos', function (Blueprint $table) {
            $table->tinyInteger('estado')->default(0);
        });
        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->tinyInteger('estado')->default(0);
        });
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->tinyInteger('estado')->default(0);
        });       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minsa_procedimientos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        Schema::table('minsa_insumos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });  
    }
};
