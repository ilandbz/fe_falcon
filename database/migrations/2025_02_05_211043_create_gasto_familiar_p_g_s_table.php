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
        Schema::create('gasto_familiar_p_g_s', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('credito_id')->on('perdida_ganancias')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('alimentacion', 8, 2)->default(0.00);
            $table->decimal('alquileres', 8, 2)->default(0.00);
            $table->decimal('educacion', 8, 2)->default(0.00);
            $table->decimal('servicios', 8, 2)->default(0.00);
            $table->decimal('transporte', 8, 2)->default(0.00);
            $table->decimal('salud', 8, 2)->default(0.00);
            $table->decimal('otros', 8, 2)->default(0.00);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_familiar_p_g_s');
    }
};
