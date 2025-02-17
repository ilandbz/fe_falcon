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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->char('dni', 8)->unique();
            $table->foreignId('cargo_id')->constrained('cargos')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('sueldo_basico')->default(0);
            $table->date('fecha_inicio');
            $table->string('estado');
            $table->string('tipo');
            $table->foreignId('agencia_id')->constrained('agencias')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
