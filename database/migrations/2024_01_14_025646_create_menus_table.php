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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->nullable();
            $table->string('icono')->nullable();
            $table->foreignId('padre_id')->nullable()->constrained('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('grupo_id')->nullable()->constrained('grupo_menus')->onUpdate('cascade')->onDelete('set null');
            $table->unsignedInteger('orden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
