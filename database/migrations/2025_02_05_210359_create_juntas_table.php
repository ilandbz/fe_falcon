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
        Schema::create('juntas', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->foreignId('cliente_id')->constrained('clientes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agencia_id')->constrained('agencias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('asesor_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('tipoplazo', 15);
            $table->integer('plazo', false, true)->length(3);
            $table->string('frecuencia', 15);
            $table->integer('nrocuotas')->length(4);
            $table->date('fecha_registro');
            $table->time('hora_registro');
            $table->decimal('monto', 8, 2);
            $table->date('fechainicio');
            $table->string('descripcion', 90)->default('AHORRO PARA EL FUTURO');
            $table->string('estado', 20)->comment('REGISTRADO, APROBADO, FINALIZADO, DEVUELTO');
            $table->string('dondepagara', 20)->comment('Oficina, Campo');
            $table->integer('idagencia', false, true)->length(4)->unsigned()->default(1);
            $table->decimal('total', 9, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juntas');
    }
};
