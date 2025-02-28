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
        Schema::create('kardex_creditos', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->foreign('credito_id')->references('credito_id')->on('desembolsos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('nro');
            $table->date('fecha');
            $table->time('hora');
            $table->decimal('montopagado', 9, 2);
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('mediopago', 35);
            $table->timestamps();
            $table->primary(['credito_id', 'nro']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardex_creditos');
    }
};
