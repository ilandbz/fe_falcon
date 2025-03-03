<?php
namespace App\Http\Traits;

use App\Models\DetCalendarioPagos;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait DesembolsoTrait
{


    function generarCalendarioPagos(Request $request)
    {
        setlocale(LC_TIME, 'es_ES.UTF-8');
        Carbon::setLocale('es');
        $total      = $request->total;
        $plazo      = $request->plazo;
        $credito_id = $request->credito_id;
        $frecuencia = $request->frecuencia;
        $fecha      = Carbon::parse($request->fecha);
        
        // Validación de frecuencia
        $frecuencias = [
            'DIARIO' => 1,
            'SEMANAL' => 7,
            'QUINCENAL' => 14,
            'MENSUAL' => 30
        ];
    
        if (!isset($frecuencias[$frecuencia])) {
            return response()->json(['error' => 'Frecuencia no válida'], 400);
        }
    
        // Calcular la cuota
        $cuota = round($total / $plazo, 2);
        $saldo = $total;
    
        for ($i = 1; $i <= $plazo; $i++) {
            // Evitar feriados si la frecuencia es diaria
            while ($frecuencia === 'DIARIO' && esFeriado($fecha->format('Y-m-d'))) {
                $fecha->addDay();
            }
    
            // Guardar en la base de datos
            DetCalendarioPagos::create([
                'credito_id'  => $credito_id,
                'nrocuota'    => $i,
                'fecha_prog'  => $fecha->toDateString(),
                'nombredia'   => $fecha->format('l'), // Nombre del día en inglés, si lo quieres en español, usa Carbon locales
                'cuota'       => ($saldo < $cuota) ? $saldo : $cuota,
                'saldo'       => max(0, $saldo - $cuota)
            ]);
    
            $saldo -= $cuota;
            $fecha->addDays($frecuencias[$frecuencia]);
        }
    
        //return response()->json(['mensaje' => 'Calendario de pagos generado con éxito'], 200);
    }

}