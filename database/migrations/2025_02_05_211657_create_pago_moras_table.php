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
        Schema::create('pago_moras', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->foreign('credito_id')->references('credito_id')->on('desembolsos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('nro');
            $table->integer('diasmora')->default(1);
            $table->decimal('total',7,2);
            $table->date('fecha');
            $table->time('hora');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_moras');
    }
};
