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
        Schema::create('balances', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('id')->on('creditos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('total_activo', 9, 2);
            $table->decimal('total_pasivo', 9, 2);
            $table->decimal('patrimonio', 9, 2);
            $table->decimal('activocaja', 9, 2)->default(0.00);
            $table->decimal('activobancos', 9, 2)->default(0.00);
            $table->decimal('activoctascobrar', 9, 2)->default(0.00);
            $table->decimal('activoinventarios', 9, 2)->default(0.00);
            $table->decimal('pasivodeudaprove', 9, 2)->default(0.00);
            $table->decimal('pasivodeudaent', 9, 2)->default(0.00);
            $table->decimal('pasivodeudaempre', 9, 2)->default(0.00);
            $table->decimal('activomueble', 9, 2)->default(0.00);
            $table->decimal('activootrosact', 9, 2)->default(0.00);
            $table->decimal('activodepre', 9, 2)->default(0.00);
            $table->decimal('pasivolargop', 9, 2)->default(0.00);
            $table->decimal('otrascuentaspagar', 9, 2)->default(0.00);
            $table->decimal('totalacorriente', 9, 2)->default(0.00);
            $table->decimal('totalpcorriente', 9, 2)->default(0.00);
            $table->decimal('totalancorriente', 9, 2)->default(0.00);
            $table->decimal('totalpncorriente', 9, 2)->default(0.00);
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
