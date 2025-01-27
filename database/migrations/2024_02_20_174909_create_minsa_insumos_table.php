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
        Schema::create('minsa_insumos', function (Blueprint $table) {
            $table->id();
            $table->string('fua')->unique();
            $table->string('lote',2);
            $table->string('numero', 8);
            $table->foreignId('paciente_id')->nullable()->constrained('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('fiss_alDiag', 6);
            $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_aplicado',11,2)->default(0);
            $table->decimal('total',11,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minsa_insumos');
    }
};
