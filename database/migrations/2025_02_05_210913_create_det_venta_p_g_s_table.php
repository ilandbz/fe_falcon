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
        Schema::create('det_venta_p_g_s', function (Blueprint $table) {
            $table->unsignedBigInteger('venta_pyg_id');
            $table->primary('venta_pyg_id');
            $table->foreign('venta_pyg_id')->references('credito_id')->on('venta_p_g_s')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('nroproducto')->default(0);
            $table->string('descripcion', 40);
            $table->string('unidadmedida', 20);
            $table->decimal('preciounit', 8, 2)->default(0.00);
            $table->decimal('primaprincipal', 8, 2)->default(0.00);
            $table->decimal('primasecundaria', 8, 2)->default(0.00);
            $table->decimal('primacomplement', 8, 2)->default(0.00);
            $table->decimal('matprima', 8, 2)->default(0.00);
            $table->decimal('manoobra1', 8, 2)->default(0.00);
            $table->decimal('manoobra2', 8, 2)->default(0.00);
            $table->decimal('manoobra', 8, 2)->default(0.00);
            $table->decimal('costoprimount', 8, 2)->default(0.00);
            $table->decimal('prodmensual', 8, 2)->default(0.00);
            $table->decimal('ventastotales', 8, 2)->default(0.00);
            $table->decimal('totcostoprimo', 8, 2)->default(0.00);
            $table->decimal('margenventas', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_venta_p_g_s');
    }
};
