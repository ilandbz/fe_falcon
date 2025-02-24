<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>POLIZA DE SEGURO</title>
    <style type="text/css">
        @page {
            margin-top: 0em;
            margin-left: 4.8em;
            margin-right: 0.4em;
            margin-bottom: 0.8em;
        }
        .micontenidoef {
            font-size: 9px;
        }
        table.conborde tr, table.conborde td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    @if ($poliza)
    <p align="center" style="margin-bottom: 0.10in; line-height: 100%">
        <b>GASTO ADMINISTRATIVO – N° {{ $poliza->credito_id }}</b>
        <b style="position: absolute; right: 20px">
            <span>S/.{{ number_format($poliza->monto, 2) }}</span>
        </b>
    </p>

    <p align="justify" style="margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><b>1.- Datos del Cliente</b></font>
    </p>

    <p align="justify" style="margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt">
            <span>Apellidos y Nombres:</span>
        </font>
        <font size="2" style="font-size: 9pt">
            <span>{{ $cliente->persona->apenom }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DNI N°: {{ $cliente->persona->dni }}</span>
        </font>
    </p>

    <p align="justify" style="margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><b>2.- Coberturas </b></font>
    </p>

    <p align="justify" style="margin-left: 0.21in; margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><b>Vida (Muerte natural y Muerte accidental)</b></font>
        <font size="2" style="font-size: 9pt">, Cubre el fallecimiento del Asegurado por causas naturales y accidentales.</font>
    </p>

    <p align="justify" style="margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><b>3.- Vigencia de la cobertura</b></font>
    </p>

    <p align="justify" style="margin-left: 0.21in; margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><u><b>Inicio de la vigencia:</b></u></font>
        <font size="2" style="font-size: 9pt">
            La vigencia de las coberturas otorgadas al amparo del presente seguro se inicia desde que el Contratante efectúe el desembolso del <b>Crédito</b>.
        </font>
    </p>

    <p align="justify" style="margin-left: 0.21in; margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><u><b>Fin de la Vigencia</b></u></font>
        <font size="2" style="font-size: 9pt">
            <b>: Las</b> coberturas se mantendrán vigentes mientras concurran las siguientes circunstancias:
            (I) se encuentre vigente el <b>Crédito</b> asegurado,
            (II) el asegurado se encuentre al día en el pago de sus cuotas.
        </font>
    </p>

    <p align="justify" style="margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt"><b>4.- Procedimiento y Requisitos para presentar una solicitud de cobertura (aviso del siniestro)</b></font>
    </p>

    <p align="justify" style="margin-left: 0.21in; margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt">
            El beneficiario o los herederos del asegurado deberán presentar la solicitud de cobertura dentro de los (7) días siguientes a la fecha de ocurrencia del siniestro, de forma escrita a través de cualquier oficina del contratante, adjuntando el original y copia certificada notarialmente de los siguientes documentos,
            <b>(I) Muerte Natural:</b> Partida de defunción,
            <b>(II) Muerte Accidental:</b> Partida de defunción y Certificado Médico de defunción.
        </font>
    </p>

    <p align="justify" style="text-indent: 0.21in; margin-bottom: 0.10in; line-height: 100%">
        <font size="2" style="font-size: 9pt">
            <b><span>Huánuco, 
                @php
                    setlocale(LC_TIME, 'es_ES.UTF-8');
                    $fecha = strtotime($credito->fecha_reg);
                    echo strftime('%d de %B de %Y', $fecha);
                @endphp
            </span></b>
        </font>
    </p>

    <p align="justify" style="margin-left: 170px">
        <font size="2" style="font-size: 9pt;">
            <b>______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;______________________________</b>
        </font>
    </p>

    <p align="justify" style="margin-top:0; margin-left: 200px">
        <font size="2" style="font-size: 9pt"><b><span>Asegurado</span></b></font>
        <font size="2" style="font-size: 9pt">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <b>Asesor Responsable</b>
        </font>
    </p>
    @else
    <h3>NO EXISTE POLIZA</h3>
    @endif

</body>
</html>
