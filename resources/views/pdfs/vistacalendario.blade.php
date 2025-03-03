<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('activos/images/logo.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('activos/css/miestilo2.css') }}">
    <title>FINANCIERA EMPRENDER</title>
    <style type="text/css">
        @page {
            margin-top: 14px;
            margin-left: 2em;
            margin-right: 2em;
            font-size: 9px;
            margin-bottom: 0px;
        }
        table.mitabla {
            border-collapse: collapse;
        }
        table.mitabla, table.mitabla th, table.mitabla td {
            border: 1px solid black;
        }
        table.mitabla td {
            padding: 3px;
        }
        table.pie {
            font-size: 11px;
        }
    </style>
</head>
<body>
<div class="container-fluid">

    @php
        // Determinar el texto del plazo según la frecuencia
        $plazoTexto = match ($credito->frecuencia) {
            'DIARIO' => 'Días',
            'SEMANAL' => 'Semanas',
            'QUINCENAL' => 'Quincenas',
            'MENSUAL' => 'Mes',
            default => ''
        };
    @endphp

    @if ($credito->plazo >= 20)
        <table width="100%">
            <tr>
                <td width="48%">
                    @include('components.calendariopagos', ['solicitud' => $credito, 'plazoTexto' => $plazoTexto])
                </td>
                <td width="4%">&nbsp;</td>
                <td width="48%">
                    @include('components.calendariopagos', ['solicitud' => $credito, 'plazoTexto' => $plazoTexto])
                </td>
            </tr>
        </table>
    @else
        @include('components.calendariopagos', ['solicitud' => $credito, 'plazoTexto' => $plazoTexto])
        <br><br>
        @include('components.calendariopagos', ['solicitud' => $credito, 'plazoTexto' => $plazoTexto])
    @endif

</div>
</body>
</html>
