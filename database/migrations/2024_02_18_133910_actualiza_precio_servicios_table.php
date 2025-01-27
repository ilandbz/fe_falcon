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
        Schema::table('precio_servicios', function (Blueprint $table) {
            $table->string('nivel1', 20)->change();
            $table->string('nivel2', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('precio_servicios', function (Blueprint $table) {
            $table->string('nivel2', 12)->change();
            $table->string('nivel2', 12)->change();
        });
    }
};
