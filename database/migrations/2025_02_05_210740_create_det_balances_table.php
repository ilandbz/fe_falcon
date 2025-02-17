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
        Schema::create('det_balances', function (Blueprint $table) {
            $table->unsignedBigInteger('credito_id');
            $table->primary('credito_id');
            $table->foreign('credito_id')->references('credito_id')->on('balances')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('activocaja', 7, 2)->default(0.00);
            $table->decimal('activobancos', 7, 2)->default(0.00);
            $table->decimal('activotascobrar', 7, 2)->default(0.00);
            $table->decimal('activoinventarios', 7, 2)->default(0.00);
            $table->decimal('pasivodeudaprove', 7, 2)->default(0.00);
            $table->decimal('pasivodeudanet', 7, 2)->default(0.00);
            $table->decimal('pasivodeudaempre', 7, 2)->default(0.00);
            $table->decimal('activomueble', 7, 2)->default(0.00);
            $table->decimal('activootrosact', 7, 2)->default(0.00);
            $table->decimal('activodepre', 7, 2)->default(0.00);
            $table->decimal('pasivolargo', 7, 2)->default(0.00);
            $table->decimal('otrascuentasapagar', 7, 2)->default(0.00);
            $table->decimal('totalacorriente', 7, 2)->default(0.00);
            $table->decimal('totalpcorriente', 7, 2)->default(0.00);
            $table->decimal('totalpncorriente', 7, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_balances');
    }
};
