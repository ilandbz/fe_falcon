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
        Schema::create('precio_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('periodo', 6)->default('202312');
            $table->foreignId('procedimiento_id')->constrained('procedimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nivel1', 12);
            $table->string('nivel2',12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_servicios');
    }
};
