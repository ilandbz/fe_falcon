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
        Schema::create('kardex_juntas', function (Blueprint $table) {
            $table->unsignedBigInteger('junta_id');
            $table->foreign('junta_id')->references('junta_id')->on('desembolsos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('nro');
            $table->date('fecha');
            $table->time('hora');
            $table->decimal('montopagado', 9, 2);
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('mediopago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex_juntas');
    }
};
