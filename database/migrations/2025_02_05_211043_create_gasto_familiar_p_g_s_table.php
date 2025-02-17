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
            $table->id();
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('credito_id')->on('perdida_ganancias')->onDelete('cascade')->onUpdate('cascade');



            
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
