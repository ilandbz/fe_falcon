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
        Schema::create('creditos_cancelars', function (Blueprint $table) {
            $table->foreignId('credito_id')->constrained('creditos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('credito_pagar_id');
            $table->foreign('credito_pagar_id')->references('credito_id')->on('desembolsos')->onUpdate('cascade')->onDelete('cascade');
            $table->string('estado')->default('debe');
            $table->decimal('saldopagar', 10, 2);
            $table->decimal('morapagar')->default(0);//sera referencial ya que cuando el estado sea pago ahi si es real, normalmente sera calculado
            $table->primary(['credito_id', 'credito_pagar_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creditos_cancelars');
    }
};
