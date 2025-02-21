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
        Schema::create('perdida_ganancias', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('id')->on('creditos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('ventas', 9, 2);
            $table->decimal('costo', 9, 2);
            $table->decimal('utilidad', 9, 2);
            $table->decimal('costonegocio', 9, 2);
            $table->decimal('utiloperativa', 9, 2);
            $table->decimal('otrosing', 9, 2);
            $table->decimal('otrosegr', 9, 2);
            $table->decimal('gast_fam', 9, 2);
            $table->decimal('utilidadneta', 9, 2);
            $table->decimal('utilnetdiaria', 9, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perdida_ganancias');
    }
};
