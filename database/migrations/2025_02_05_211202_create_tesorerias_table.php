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
        Schema::create('tesorerias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_entidad_id')->constrained('tipo_entidads')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agencia_id')->constrained('agencias')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('nro')->unsigned()->zerofill(9);
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo', 18)->comment('Ingreso o Egreso');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->decimal('saldo', 10, 2);
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tesorerias');
    }
};
