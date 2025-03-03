<table width="100%">
    <tr>
        <th colspan="6">CALENDARIO DE PAGOS</th>
    </tr>
    <tr>
        <th align="left">FECHA DES.</th>
        <td align="left">{{ $desembolso->fechahora }}</td>
        <th align="left">Monto</th>
        <td align="left">S/.{{ number_format($solicitud->monto, 2) }}</td>
        <th align="left">Plazo</th>
        <td align="left">{{ $solicitud->plazo }} {{ $plazoTexto }}</td>
    </tr>
    <tr>
        <th align="left">Cliente</th>
        <td align="left" colspan="3">{{ $solicitud->apenom }}</td>
        <th align="left">IDCLIENTE</th>
        <td align="left">{{ $solicitud->codcliente }}</td>
    </tr>
    <tr>
        <th align="left">DIR domic</th>
        <td colspan="5">{{ $domicilio->direccion }}</td>
    </tr>
    @if(isset($negocio) && $solicitud->ubicaciondomicilio != $negocio->idubicacion)
        <tr>
            <th align="left">DIR. Negocio</th>
            <td colspan="5">{{ $domicilionegocio->direccion }}</td>
        </tr>
    @endif
</table>

<table width="100%" class="mitabla">
    <tr>
        <th width="5%">N°</th>
        <th width="15%">FECHA PROG.</th>
        <th width="10%">DIA</th>
        <th width="10%">CUOTA</th>
        <th width="15%">MONTO PAGADO</th>
        <th>FEC. PAGO</th>
        <th>SALDO</th>
        <th>FIRMA</th>
    </tr>			
    <tr>
        <td colspan="6"></td>
        <td>S/.{{ number_format($solicitud->monto + $solicitud->interes, 2) }}</td>		
        <td></td>		
    </tr>
    @foreach($cuotapagos as $row)
        <tr>
            <td>{{ $row->nrocuota }}</td>
            <td>{{ \Carbon\Carbon::parse($row->fecha_prog)->format('d-m-Y') }}</td>
            <td>{{ $row->nombredia }}</td>
            <td>S/.{{ number_format($row->cuota, 2) }}</td>
            <td></td>
            <td></td>
            <td>S/.{{ number_format($row->saldo, 2) }}</td>
            <td></td>
        </tr>
    @endforeach
</table>

<table width="100%" class="pie">
    <tr>
        <th align="left" width="15%">ASESOR</th>
        <td align="left" width="50%">{{ $asesor->apenom }}</td>
        <th align="left" width="15%">CELULAR</th>
        <td align="left" width="20%">{{ $asesor->celular }}</td>
    </tr>
    <tr>
        <th align="left" width="15%"></th>
        <td align="left" width="50%"></td>
        <th align="left" width="15%">YAPE</th>
        <td align="left" width="20%">920275552</td>
    </tr>	
    <tr>
        <td colspan="2" style="font-size: 10px;">
            Por cada día de atraso se le cobrará una mora de S/.{{ number_format($solicitud->costomora, 2) }}
        </td>
        <td colspan="2" style="font-size: 14px;">
            {{ $agencia->direccion }}
        </td>
    </tr>
</table>
