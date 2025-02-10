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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agencia_id')->constrained('agencias','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('usuario_id')->constrained('users','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('persona_id')->constrained('personas','id')->onDelete('cascade')->onUpdate('cascade');
            $table->char('dniaval', 8)->nullable();
            $table->string('estado', 25)->default('REGISTRADO');
            $table->date('fecha_reg');
            $table->time('hora_reg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
