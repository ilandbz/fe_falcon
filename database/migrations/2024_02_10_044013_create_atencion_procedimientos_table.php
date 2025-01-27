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
        Schema::create('atencion_procedimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->foreignId('atencion_diagnostico_id')->constrained('atencion_diagnosticos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('procedimiento_id')->constrained('procedimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('apro_CantIndicado');
            $table->integer('apro_CantEjecutado');
            $table->decimal('precio_unitario',11,2);
            $table->string('resultado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_procedimientos');
    }
};
