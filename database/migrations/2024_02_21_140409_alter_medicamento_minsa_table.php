<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->string('periodo', 6);
        });
    }

    public function down()
    {
        Schema::table('minsa_medicamentos', function (Blueprint $table) {
            $table->dropColumn('periodo');
        });
    }
};
