<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SOLICITUD</title>
    <style type="text/css">
        @page {
            margin-top: 2em;
            margin-left: 4.2em;
        }
        th, td {
            text-align: left;
        }
        table {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
        }
        tr.conborde th, tr.conborde td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

<div align="center">
    <h4>SOLICITUD</h4>
</div>

<table>
    <tr>
        <th>COD SOLICITUD</th>
        <td>{{ $credito->id ?? 'N/A' }}</td>
        <th>Monto</th>
        <td>S/. {{ number_format($credito->monto ?? 0, 2) }}</td>
        <th>FECHA</th>
        <td>{{ $credito->fecha_reg ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>PRODUCTO</th>
        <td>{{ $credito->producto ?? 'N/A' }}</td>
        
        @php
            $frecuencia = match($credito->frecuencia ?? '') {
                'DIARIO' => 'Días',
                'SEMANAL' => 'Semanas',
                'QUINCENAL' => 'Quincenas',
                'MENSUAL' => 'Meses',
                default => 'N/A',
            };
        @endphp
        
        <th>PLAZO</th>
        <td>{{ $credito->plazo ?? 'N/A' }} {{ $frecuencia }}</td>
        <th>TIPO PRÉSTAMO</th>
        <td>{{ $credito->tipo ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>ASESOR</th>
        <td colspan="3">{{ $asesor->persona->apenom ?? 'N/A' }}</td>
        <th>ID</th>
        <td>{{ $asesor->name ?? 'N/A' }}</td>
    </tr>
    <tr class="conborde">
		<th style="padding-top:8px; padding-bottom:8px;" colspan="6" align="center">DATOS DEL CLIENTE</th>
	</tr>
	<tr class="conborde">
		<th>Apellidos y Nombres</th><td colspan="3">{{ $cliente->persona->apenom }}</td><th>COD</th><td>{{ $cliente->id }}</td>
	</tr>
	<tr class="conborde">
		<th>DNI</th><td>{{ $cliente->persona->dni }}</td>
		<th>RUC</th><td>{{ $cliente->persona->ruc ?? 'NO TIENE'  }}</td>
		<th>EDAD</th><td>{{ $cliente->persona->edad }}</td>
	</tr>
    <tr class="conborde">
        <th>GÉNERO</th>
        <td>{{ $cliente->persona->genero == 'M' ? 'MASCULINO' : 'FEMENINO' }}</td>
        <td>&nbsp;</td>
        <th colspan="2">ESTADO CIVIL</th>
        <td>{{ $cliente->persona->estado_civil }}</td>
    </tr>
    <tr class="conborde">
        <th colspan="2">GRADO DE INSTRUCCIÓN</th>
        <td>{{ $cliente->persona->grado_instr }}</td>
        <td>&nbsp;</td>
        <th>NACIONALIDAD</th>
        <td>{{ $cliente->persona->nacionalidad }}</td>
    </tr>
    <tr class="conborde">
        <th colspan="2">TIPO DE TRABAJADOR</th>
        <td>{{ $cliente->persona->tipo_trabajador }}</td>
        <td>&nbsp;</td>
        <th>ESTADO</th>
        <td>{{ $cliente->estado }}</td>
    </tr>
    <tr class="conborde">
        <th>CELULAR</th>
        <td>{{ $cliente->persona->celular }}</td>
        <td>&nbsp;</td>
        <th>EMAIL</th>
        <td colspan="2">{{ $cliente->persona->email }}</td>
    </tr>
	<tr class="conborde">
		<th style="padding-top:8px; padding-bottom:8px;" colspan="6" align="center">DOMICILIO CLIENTE</th>
	</tr>
	<tr class="conborde">
		<th>TIPO DE VIVIENDA</th><td colspan="5">{{ $domicilio->tipo }}</td>
	</tr>	
	<tr class="conborde">
		<th>DEPARTAMENTO</th><td>{{ $domicilio->distrito->provincia->departamento->nombre }}</td><th>PROVINCIA</th><td>{{ $domicilio->distrito->provincia->nombre }}</td><th>DISTRITO</th><td>{{ $domicilio->distrito->nombre }}</td>
	</tr>
	<tr class="conborde">
		<td colspan="6">
            {{ $domicilio->direccion }}
		</td>
	</tr>
    <tr class="conborde">
		<th>REFERENCIA</th><td colspan="5">{{ $domicilio->referencia }}</td>
	</tr>
	<tr class="conborde">
		<th style="padding-top:8px; padding-bottom:8px;" align="center" colspan="6">NEGOCIO</th>
	</tr>
    @if(!is_null($negocio))
        <tr class="conborde">
            <th colspan="2">Nombre del Negocio</th>
            <td colspan="4" align="left">
                {{ $negocio->razonsocial == '' ? 'NO TIENE' : $negocio->razonsocial }}
            </td>
        </tr>
        <tr class="conborde">
            <th>RUC</th>
            <td>{{ $negocio->ruc == '' ? 'NO TIENE' : $negocio->ruc }}</td>
            <th>Telefono/Cel</th>
            <td colspan="3">{{ $negocio->tel_cel }}</td>
        </tr>
        <tr class="conborde">
            <th>Actividad</th>
            <td>{{ $negocio->actividad }}</td>
            <th>Actividad Espec.</th>
            <td colspan="4">{{ $negocio->descripcion }}</td>
        </tr>
        <tr class="conborde">
            <th>Inicio de Actividad</th>
            <td>{{ $negocio->inicioactividad }}</td>
            <th colspan="2">TIEMPO DE ACTIVIDAD</th>
            <td colspan="2">{{ $negocio->tiemponegocio }} años</td>
        </tr>
        <tr class="conborde">
            <th style="padding-top:8px; padding-bottom:8px;" colspan="6" align="center">DIRECCIÓN NEGOCIO</th>
        </tr>
        <tr class="conborde">
            <th>DEPARTAMENTO</th>
            <td>{{ $ubicacionnegocio->distrito->provincia->departamento->nombre }}</td>
            <th>PROVINCIA</th>
            <td>{{ $ubicacionnegocio->distrito->provincia->nombre }}</td>
            <th>DISTRITO</th>
            <td>{{ $ubicacionnegocio->distrito->nombre }}</td>
        </tr>
        <tr class="conborde">
            <td colspan="6">{{ $ubicacionnegocio->direccion }}</td>
        </tr>
        <tr class="conborde">
            <th>Referencia : </th>
            <td colspan="5" align="left">{{ $ubicacionnegocio->referencia }}</td>
        </tr>
    @else
        <tr class="conborde">
            <td colspan="6">NO POSEE</td>
        </tr>
    @endif

</table>

</body>
</html>
