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
        Schema::create('venta_p_g_s', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('id')->on('creditos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('tot_ing_mensual', 9, 2);
            $table->decimal('tot_cosprimo_m', 9, 2);
            $table->decimal('margen_tot', 9, 2);
            $table->decimal('ventas_cred', 9, 2);
            $table->decimal('irrecuperable', 9, 2);
            $table->integer('cantproductos')->length(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_p_g_s');
    }
};
