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
        Schema::create('atencion_diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->foreignId('atencion_id')->constrained('atencions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tipo_diagnostico_id')->constrained('tipo_diagnosticos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tipo_ingreso_egresos_id')->constrained('tipo_ingreso_egresos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_diagnosticos');
    }
};
