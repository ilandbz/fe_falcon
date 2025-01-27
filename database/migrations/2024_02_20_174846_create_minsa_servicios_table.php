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
        Schema::create('minsa_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('fua')->unique();
            $table->string('lote',2);
            $table->string('numero', 8);
            $table->string('contrato');
            $table->foreignId('paciente_id')->nullable()->constrained('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('valorNetoServ',11,2)->default(0);
            $table->decimal('valorNetoMedi',11,2)->default(0);
            $table->decimal('valorNetoProc',11,2)->default(0);
            $table->decimal('valorNetoInsu',11,2)->default(0);
            $table->decimal('valorNeto',11,2)->default(0);
            $table->decimal('valorBrutoServ',11,2)->default(0);
            $table->decimal('valorBrutoMedi',11,2)->default(0);
            $table->decimal('valorBrutoProc',11,2)->default(0);
            $table->decimal('valorBrutoInsu',11,2)->default(0);
            $table->decimal('valorBruto',11,2)->default(0);
            $table->date('ate_fecate');
            $table->date('ate_fecing');
            $table->string('periodo', 6);
            $table->string('Capita', 6);
            $table->tinyInteger('estado')->default(0);
            $table->string('fuente_financiamiento', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minsa_servicios');
    }
};
