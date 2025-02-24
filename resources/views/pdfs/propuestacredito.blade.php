<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('activos/images/logo.ico') }}">
	<title>PROPUESTA DE CREDITO</title>
	<style>
		th {
			padding-top: 40px;
		}
	</style>
</head>
<body>

<br>
<div align="center">
	<br>
	<h3>PROPUESTA DE CREDITO</h3>
</div>

<table width="100%">
	<tr>
		<td>ID SOLICITUD</td>
		<td>{{ $credito->id }}</td>
		<td>TITULAR</td>
		<td>{{ $cliente->persona->apenom }}</td>
	</tr>
	<tr>
		<td>FECHA SOLIC</td>
		<td>{{ $credito->fecha_reg }}</td>
		<td>Monto</td>
		<td>{{ $credito->monto }}</td>
	</tr>
</table>

<table width="100%" align="left">
	<tr>
		<th align="left">UNIDAD FAMILIAR (CONYUGUE, HIJOS)</th>
	</tr>
	<tr>
		<td align="justify">
			@empty($propuestacred->unidad_familiar)
				NINGUNO
			@else
				{{ $propuestacred->unidad_familiar }}
			@endempty
		</td>
	</tr>

	<tr>
		<th align="left">EXPERIENCIA CREDITICIA Y NEGOCIO</th>
	</tr>
	<tr>	
		<td align="justify">
			@empty($propuestacred->experiencia_cred)
				NINGUNO
			@else
				{{ $propuestacred->experiencia_cred }}
			@endempty
		</td>
	</tr>

	<tr>
		<th align="left">DESTINO DEL PRESTAMO</th>
	</tr>
	<tr>	
		<td align="justify">
			@empty($propuestacred->destino_prest)
				NINGUNO
			@else
				{{ $propuestacred->destino_prest }}
			@endempty
		</td>
	</tr>

	<tr>
		<th align="left">REFERENCIAS PERSONALES Y COMERCIALES</th>
	</tr>
	<tr>	
		<td align="justify">
			@empty($propuestacred->referencias)
				NINGUNO
			@else
				{{ $propuestacred->referencias }}
			@endempty
		</td>
	</tr>
</table>

</body>
</html>
