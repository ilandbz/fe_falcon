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
        Schema::create('gasto_negocio_p_g_s', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('credito_id')->on('perdida_ganancias')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('alquiler', 7, 2)->nullable();
            $table->decimal('servicios', 7, 2)->nullable();
            $table->decimal('personal', 7, 2)->nullable();
            $table->decimal('sunat', 7, 2)->nullable();
            $table->decimal('transporte', 7, 2)->nullable();
            $table->decimal('gastosfinancieros', 7, 2)->nullable();
            $table->decimal('otros', 7, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_negocio_p_g_s');
    }
};
