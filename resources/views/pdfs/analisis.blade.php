<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ANALISIS CUALITATIVO</title>
    <style>
        body {
            font-size: 11px;
        }
    </style>
</head>
<body>

<div align="center">
    <h3>ANÁLISIS CUALITATIVO</h3>
</div>
<hr>
<p>I. UNIDAD FAMILIAR</p>
<hr>

@php
    $analisiscualitativo = $analisiscualitativo ?? (object) [
        'tipogarantia' => 0,
        'cargafamiliar' => 0,
        'riesgoedadmax' => 0,
        'totunidfamiliar' => 0,
        'antecedentescred' => 0,
        'recorpagoult' => 0,
        'niveldesarr' => 0,
        'tiempo_neg' => 0,
        'control_ingegre' => 0,
        'vent_totdec' => 0,
        'compsubsector' => 0,
        'totunidempresa' => 0, 
        'total' => 0
    ];
@endphp

<table width="100%">
    <tr>
        <th colspan="3" align="left">1. TIPO DE GARANTÍA</th>
    </tr>
    <tr>
        <td width="80%">REAL CONSTITUIDA A FAVOR DE LA INSTITUCIÓN (HIPOTECA Y/O PRENDA)</td>
        <td>4</td>
        <td>@if($analisiscualitativo->tipogarantia == 4) X @endif</td>
    </tr>
    <tr>
        <td>SIMPLE</td>
        <td>2</td>
        <td>@if($analisiscualitativo->tipogarantia == 2) X @endif</td>
    </tr>
    <tr>
        <th colspan="3" align="left">2. CARGA FAMILIAR</th>
    </tr>    
    <tr>
        <td>NO TIENE DEPENDIENTES</td>
        <td>4</td>
        <td>@if($analisiscualitativo->cargafamiliar == 4) X @endif</td>
    </tr>
    <tr>
        <td>TIENE DEPENDIENTES NO VULNERABLES</td>
        <td>2</td>
        <td>@if($analisiscualitativo->cargafamiliar == 2) X @endif</td>
    </tr>
    <tr>
        <td>TIENE DEPENDIENTES MENORES A 5 AÑOS</td>
        <td>1</td>
        <td>@if($analisiscualitativo->cargafamiliar == 1) X @endif</td>
    </tr>
    <tr>
        <td>TIENE ALGÚN DEPENDIENTE CON ENFERMEDADES FRECUENTES Y/O GRAVES</td>
        <td>0</td>
        <td>@if($analisiscualitativo->cargafamiliar == 0) X @endif</td>
    </tr>
    
    <tr>
        <td>MENOR DE 64 AÑOS</td>
        <td>3</td>
        <td>@if($analisiscualitativo->riesgoedadmax == 3) X @endif</td>
    </tr>
    <tr>
        <td>MAYOR O IGUAL A 64 AÑOS</td>
        <td>1</td>
        <td>@if($analisiscualitativo->riesgoedadmax == 1) X @endif</td>
    </tr>
    <tr>
        <th>TOTAL PUNTAJE UNIDAD FAMILIAR</th>
        <td colspan="2">{{ $analisiscualitativo->totunidfamiliar }}</td>
    </tr>
</table>

<hr>
<p>II. UNIDAD EMPRESARIAL</p>
<hr>

</body>
</html>
