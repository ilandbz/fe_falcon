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
        Schema::table('establecimientos', function (Blueprint $table) {
            $table->integer('pre_IdDisa');
            $table->string('pre_CodigoRENAES', 10);
        });  
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('establecimientos', function (Blueprint $table) {
            $table->dropColumn('pre_IdDisa');
            $table->dropColumn('pre_CodigoRENAES');
        });  
    }
};
