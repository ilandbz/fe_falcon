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
        Schema::create('billetajes', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fechahora');
            $table->integer('f2000')->default(0);
            $table->integer('f1000')->default(0);
            $table->integer('b200')->default(0);
            $table->integer('b100')->default(0);
            $table->integer('b50')->default(0);
            $table->integer('b20')->default(0);
            $table->integer('b10')->default(0);
            $table->integer('m5')->default(0);
            $table->integer('m2')->default(0);
            $table->integer('m1')->default(0);
            $table->integer('m50')->default(0);
            $table->integer('m20')->default(0);
            $table->integer('m10')->default(0);
            $table->decimal('total', 9, 2)->default(0.00);
            $table->foreignId('agencia_id')->constrained('agencias','id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billetajes');
    }
};
