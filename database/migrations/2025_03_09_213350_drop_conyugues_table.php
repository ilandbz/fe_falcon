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
        Schema::table('conyugues', function (Blueprint $table) {
            Schema::dropIfExists('conyugues');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conyugues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('primer_persona_id')->constrained('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('segunda_persona_id')->constrained('personas')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
