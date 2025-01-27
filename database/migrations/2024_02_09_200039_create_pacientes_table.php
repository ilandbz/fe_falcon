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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nro_documento', 15)->unique();
            $table->string('ape_paterno');
            $table->string('ape_materno');
            $table->string('primer_nombre');
            $table->string('segundo_nombre');
            $table->date('fecha_nacimiento');
            $table->foreignId('sexo_id')->constrained('sexos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
