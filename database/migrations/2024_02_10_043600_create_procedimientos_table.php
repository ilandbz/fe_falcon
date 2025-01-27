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
        Schema::create('procedimientos', function (Blueprint $table) {
            $table->id();
            $table->string('PRCD_ID_PROCEDIMIENTO');
            $table->string('PRCD_V_CODPRO_MINSA', 15)->nullable();
            $table->string('PRCD_V_CODPROCEDIMIENTO', 15)->nullable();
            $table->string('PRCD_V_DESPROCEDIMIENTO', 200)->nullable();
            $table->char('PRCD_I_ESTADO', 1)->nullable();
            $table->date('PRCD_D_FECBAJA')->nullable();
            $table->string('PRCD_V_CODSEG', 15)->nullable();
            $table->string('PRCD_V_CODGRU', 2)->nullable();
            $table->string('PRCD_V_CODSUB', 2)->nullable();
            $table->string('PRCD_V_DOCUMENTO', 200)->nullable();
            $table->unsignedBigInteger('PRCD_I_IDUSUARIOCREA')->nullable();
            $table->date('PRCD_D_FECCREA')->nullable();
            $table->string('PRCD_V_DOCUMENTOCREA', 100)->nullable();
            $table->unsignedBigInteger('PRCD_I_IDUSUARIOACT')->nullable();
            $table->date('PRCD_D_FECACT')->nullable();
            $table->string('PRCD_V_DOCUMENTOACT', 100)->nullable();
            $table->tinyInteger('PRCD_B_FLAGREGISTROELIMINADO')->nullable();
            $table->char('PRCD_C_CONDICION', 1)->nullable();
            $table->char('PRCD_V_TIPORESULTADO', 1)->nullable();
            $table->string('PRCD_V_CODPROCEDIMEQUIVALEN', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedimientos');
    }
};
