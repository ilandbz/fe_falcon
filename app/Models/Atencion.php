<?php

namespace App\Models;

use App\Http\Traits\AtencionTrait;
use App\Http\Traits\ReportesTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atencion extends Model
{
    use HasFactory, ReportesTrait, AtencionTrait;

    protected $fillable = [
        'fua',
        'codigo',
        'lote',
        'numero',
        'establecimiento_id',
        'componente_id',
        'tipo_formato_id',
        'disaformato',
        'lote_formato',
        'nro_formato',
        'paciente_id',
        'tipo_atencion_id',
        'condicion_materna_id',
        'modalidad_atencion_id',
        'fecha_atencion',
        'hora_atencion',
        'codigo_historia_clinica',
        'fecha_parto',
        'origen_personal_id',
        'servicio_id',
        'establecimiento_refiere_id',
        'nrohojasrefirio',
        'destino_asegurado_id',
        'establecimiento_contrarefiere_id',
        'nrohojascontrarefiere',
        'fecha_ingreso',
        'fecha_alta',
        'fecha_fallecimiento',
        'profesional_id',
        'idespecialidad',
        'nroespecialidad',
        'observacion',
        'edad',
        'grupo_etareo_id',
        'autogenerado',
        'idPPDD',
        'idOdeSis',
        'idusuariotrans',
        'fechatrans',
        'grupo_riesgo_id',
        'costo_servicio',
        'costo_medicina',
        'costo_insumo',
        'costo_procedimiento',
        'costo_total',
        'periodo_id',
        'envio',
        'supervision_id',
        'version',
        'correlativo',
        'usuario_tran_id',
        'ups',
        'hora_digitalizacion'
    ];
    /**
     * Get the paciente that owns the Atencion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Get the establecimiento that owns the Atencion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establecimiento(): BelongsTo
    {
        return $this->belongsTo(Establecimiento::class, 'establecimiento_id');
    }


    /**
     * Get the usuarioTrans that owns the Atencion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuarioTrans(): BelongsTo
    {
        return $this->belongsTo(UsuarioTrans::class, 'usuario_tran_id');
    }

    public function profesionales(): BelongsTo
    {
        return $this->belongsTo(Profesional::class, 'profesional_id');
    }

}
