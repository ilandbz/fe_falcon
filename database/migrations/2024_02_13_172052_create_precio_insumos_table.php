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
        Schema::create('precio_insumos', function (Blueprint $table) {
            $table->id();
            $table->string('CPERIODO');
            $table->string('CCODUE');
            $table->foreignId('insumo_id')->constrained('insumos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('TIPOCOMP');
            $table->decimal('PREADJ',11, 2);
            $table->decimal('PREOPE',11, 2);
            $table->string('CODIGO_SIGA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_insumos');
    }
};
