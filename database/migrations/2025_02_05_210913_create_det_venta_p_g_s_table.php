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
            $table->id(); // Nueva clave primaria única
            $table->unsignedBigInteger('credito_id');
            $table->integer('nroproducto')->default(0);
            
            // Asegurar que la combinación de credito_id y nroproducto sea única
            $table->unique(['credito_id', 'nroproducto']);

            // Definir la clave foránea correctamente
            $table->foreign('credito_id')
                  ->references('credito_id')
                  ->on('venta_p_g_s')// mejor aca ya que cuando es nuevo debe guardarse sin necesidad de tener registro de venta
                //   ->on('venta_p_g_s')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Campos adicionales
            $table->string('descripcion', 40);
            $table->string('unidadmedida', 20);
            $table->decimal('preciounit', 9, 2)->default(0.00);
            $table->decimal('primaprincipal', 9, 2)->default(0.00);
            $table->decimal('primasecundaria', 9, 2)->default(0.00);
            $table->decimal('primacomplement', 9, 2)->default(0.00);
            $table->decimal('matprima', 9, 2)->default(0.00);
            $table->decimal('manoobra1', 9, 2)->default(0.00);
            $table->decimal('manoobra2', 9, 2)->default(0.00);
            $table->decimal('manoobra', 9, 2)->default(0.00);
            $table->decimal('costoprimount', 9, 2)->default(0.00);
            $table->decimal('prodmensual', 9, 2)->default(0.00);
            $table->decimal('ventastotales', 9, 2)->default(0.00);
            $table->decimal('totcostoprimo', 9, 2)->default(0.00);
            $table->decimal('margenventas', 9, 2)->default(0.00);

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
