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
        Schema::table('precio_servicios', function (Blueprint $table) {
            // Eliminar la columna procedimiento_id existente
            $table->dropForeign(['procedimiento_id']);
            $table->dropColumn('procedimiento_id');

            // Agregar la nueva columna procedimiento_nuevo_id
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('precio_servicios', function (Blueprint $table) {
            // Deshacer los cambios en caso de un rollback
            $table->dropForeign(['servicio_id']);
            $table->dropColumn('servicio_id');

            // Volver a agregar la columna procedimiento_id original
            $table->foreignId('procedimiento_id')->constrained('procedimientos')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
