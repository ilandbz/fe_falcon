<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('nro_documento', 15)->nullable()->change();
            $table->dropUnique(['nro_documento']);
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('nro_documento', 15)->unique()->change();
        });
    }
};
