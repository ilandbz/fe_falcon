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
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agencia_id')->constrained('agencias')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('nro');
            $table->string('tipo', 5);
            $table->string('tipo_descripcion', 30);
            $table->string('tipo_comprobante', 30);
            $table->char('ruc', 11);
            $table->string('nrocomprobante', 20);
            $table->string('razonsocial', 90);
            $table->string('concepto', 90);
            $table->decimal('monto', 9, 2);
            $table->char('usuario', 9);
            $table->dateTime('fecharegistro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('egresos');
    }
};
