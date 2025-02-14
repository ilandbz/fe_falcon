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
        Schema::create('propuesta_creditos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credito_id')->constrained('creditos','id')->onDelete('cascade')->onUpdate('cascade');
            $table->text('unidad_familiar')->default('NINGUNO');
            $table->text('experiencia_cred')->default('NINGUNO');
            $table->text('destino_prest')->default('NINGUNO');
            $table->text('referencias')->default('NINGUNO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propuesta_creditos');
    }
};
