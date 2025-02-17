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
        Schema::create('garantias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credito_id')->constrained('creditos')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('tasa', 3, 1);
            $table->decimal('fondo', 9, 2);
            $table->dateTime('fecha');
            $table->string('estado', 12)->default('Registrado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garantias');
    }
};
