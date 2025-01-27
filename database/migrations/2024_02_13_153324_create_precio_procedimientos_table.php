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
        Schema::create('precio_procedimientos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo', 6)->default('202312');
            $table->foreignId('procedimiento_id')->constrained('procedimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('nivel2', 11, 2);
            $table->decimal('nivel3',11, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_procedimientos');
    }
};
