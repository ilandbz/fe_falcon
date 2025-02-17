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
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('id')->on('creditos')->onDelete('cascade')->onUpdate('cascade');
            $table->text('unidad_familiar');
            $table->text('experiencia_cred');
            $table->text('destino_prest');
            $table->text('referencias');
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
