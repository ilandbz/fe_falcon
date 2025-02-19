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
        Schema::create('analisis_cualitativos', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('id')->on('creditos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('tipogarantia');
            $table->unsignedInteger('cargafamiliar');
            $table->unsignedInteger('riesgoedadmax');
            $table->unsignedInteger('antecedentescred');
            $table->unsignedInteger('recorpagoult');
            $table->unsignedInteger('niveldesarr');
            $table->unsignedInteger('tiempo_neg');
            $table->unsignedInteger('control_ingegre');
            $table->unsignedInteger('vent_totdec');
            $table->unsignedInteger('compsubsector');
            $table->unsignedInteger('totunidfamiliar');
            $table->unsignedInteger('totunidempresa');
            $table->unsignedInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_cualitativos');
    }
};
