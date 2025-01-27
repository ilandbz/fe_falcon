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
        Schema::create('atencions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->integer('lote');
            $table->string('numero', 8);
            $table->foreignId('establecimiento_id')->constrained('establecimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('componente_id')->constrained('componentes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tipo_formato_id')->nullable()->constrained('tipo_formatos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('disaformato', 6);
            $table->string('lote_formato', 6);
            $table->string('nro_formato', 10);
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tipo_atencion_id')->nullable()->constrained('tipo_atencions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('condicion_materna_id')->nullable()->constrained('condicion_maternas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('modalidad_atencion_id')->nullable()->constrained('modalidad_atencions')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha_atencion');
            $table->time('hora_atencion');
            $table->string('codigo_historia_clinica', 10);
            $table->date('fecha_parto')->nullable();
            $table->foreignId('origen_personal_id')->constrained('origen_personals')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('establecimiento_refiere_id')->nullable()->constrained('establecimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nrohojasrefirio');
            $table->foreignId('destino_asegurado_id')->constrained('destino_asegurados')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('establecimiento_contrarefiere_id')->nullable()->constrained('establecimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nrohojascontrarefiere');
            $table->date('fecha_ingreso');
            $table->date('fecha_alta')->nullable();
            $table->date('fecha_fallecimiento')->nullable();
            $table->foreignId('profesional_id')->constrained('profesionals')->onDelete('cascade')->onUpdate('cascade');
            $table->string('idespecialidad')->nullable();
            $table->string('nroespecialidad')->nullable();
            $table->text('observacion');
            $table->integer('edad');
            $table->foreignId('grupo_etareo_id')->constrained('grupo_etareos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('autogenerado');
            $table->string('idPPDD');
            $table->string('idOdeSis');
            $table->string('idusuariotrans');
            $table->date('fechatrans')->nullable();
            $table->foreignId('grupo_riesgo_id')->constrained('grupo_riesgos')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('costo_servicio',11,2);
            $table->decimal('costo_medicina',11,2);
            $table->decimal('costo_insumo',11,2);
            $table->decimal('costo_procedimiento',11,2);
            $table->decimal('costo_total',11,2);
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('envio');
            $table->foreignId('supervision_id')->nullable()->constrained('supervisions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('version');
            $table->string('correlativo', 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencions');
    }
};
