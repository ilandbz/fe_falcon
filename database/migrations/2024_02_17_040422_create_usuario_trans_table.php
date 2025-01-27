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
        Schema::create('usuario_trans', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 8)->unique();
            $table->string('ape_paterno');
            $table->string('ape_materno');
            $table->string('primer_nombre');
            $table->string('segundo_nombre');
            $table->string('user_login');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_trans');
    }
};
