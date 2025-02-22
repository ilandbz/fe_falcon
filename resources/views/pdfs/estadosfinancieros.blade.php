<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FINANCIERA TU AMIGO</title>
    <style type="text/css">
        @page {
            margin-top: 0.8em;
            margin-left: 4.8em;
            margin-right: 0.4em;
            margin-bottom: 0.8em;
        }
        .micontenidoef {
            font-size: 9px;
        }
        table.conborde {
            width: 100%;
            border-collapse: collapse;
        }
        table.conborde th, table.conborde td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div align="center">
        <h4>ESTADOS FINANCIEROS</h4>
    </div>

    <div class="micontenidoef">
        @php
            $balance = $balance ?? [
                'activocaja' => 0.00, 'activobancos' => 0.00, 'activoctascobrar' => 0.00, 
                'activoinventarios' => 0.00, 'totalacorriente' => 0.00, 'activomueble' => 0.00, 
                'activootrosact' => 0.00, 'activodepre' => 0.00, 'totalancorriente' => 0.00, 
                'pasivodeudaprove' => 0.00, 'pasivodeudaent' => 0.00, 'pasivodeudaempre' => 0.00, 
                'totalpcorriente' => 0.00, 'pasivolargop' => 0.00, 'otrascuentaspagar' => 0.00, 
                'totalpncorriente' => 0.00
            ];

            $balance = $balance ?? [
                'total_activo' => 0.00, 'total_pasivo' => 0.00, 'patrimonio' => 0.00
            ];

            $ventaspyg = $ventaspyg ?? [
                'tot_ing_mensual' => 0.00, 'tot_cosprimo_m' => 0.00, 'margen_tot' => 0.00, 
                'ventas_cred' => 0.00, 'irrecuperable' => 0.00, 'cant_producto' => 0
            ];

            $perdidasganancias = $perdidasganancias ?? [
                'ventas' => 0.00, 'costo' => 0.00, 'utilidad' => 0.00, 'costonegocio' => 0.00, 
                'utiloperativa' => 0.00, 'otrosing' => 0.00, 'otrosegr' => 0.00, 'gast_fam' => 0.00, 
                'utilidadneta' => 0.00, 'utilnetdiaria' => 0.00
            ];

            $gastosnegocios = $gastosnegocios ?? [
                'alquiler' => 0.00, 'servicios' => 0.00, 'personal' => 0.00, 
                'sunat' => 0.00, 'transporte' => 0.00, 'gastosfinancieros' => 0.00
            ];
        @endphp

        <table class="conborde">
            <tr>
                <th colspan="2">Activo Corriente</th>
                <th colspan="2">Pasivo Corriente</th>
            </tr>
            <tr>
                <td>Caja</td>
                <td>{{ number_format($balance['activocaja'], 2) }}</td>
                <td>Deudas Proveedores</td>
                <td>{{ number_format($balance['pasivodeudaprove'], 2) }}</td>
            </tr>
            <tr>
                <td>Bancos</td>
                <td>{{ number_format($balance['activobancos'], 2) }}</td>
                <td>Deudas Entidades</td>
                <td>{{ number_format($balance['pasivodeudaent'], 2) }}</td>
            </tr>
            <tr>
                <td>Cuentas por Cobrar</td>
                <td>{{ number_format($balance['activoctascobrar'], 2) }}</td>
                <td>Deudas Empresas</td>
                <td>{{ number_format($balance['pasivodeudaempre'], 2) }}</td>
            </tr>
            <tr>
                <td>Inventarios</td>
                <td>{{ number_format($balance['activoinventarios'], 2) }}</td>
                <td>Total Pasivo Corriente</td>
                <td>{{ number_format($balance['totalpcorriente'], 2) }}</td>
            </tr>
            <tr>
                <th colspan="2">Activo No Corriente</th>
                <th colspan="2">Pasivo No Corriente</th>
            </tr>
            <tr>
                <td>Muebles y Enseres</td>
                <td>{{ number_format($balance['activomueble'], 2) }}</td>
                <td>Pasivo Largo Plazo</td>
                <td>{{ number_format($balance['pasivolargop'], 2) }}</td>
            </tr>
            <tr>
                <td>Otros Activos</td>
                <td>{{ number_format($balance['activootrosact'], 2) }}</td>
                <td>Otras Cuentas por Pagar</td>
                <td>{{ number_format($balance['otrascuentaspagar'], 2) }}</td>
            </tr>
            <tr>
                <td>Depreciación</td>
                <td>{{ number_format($balance['activodepre'], 2) }}</td>
                <td>Total Pasivo No Corriente</td>
                <td>{{ number_format($balance['totalpncorriente'], 2) }}</td>
            </tr>
            <tr>
                <td>Total Activo</td>
                <td>{{ number_format($balance['total_activo'], 2) }}</td>
                <td>Total Pasivo</td>
                <td>{{ number_format($balance['total_pasivo'], 2) }}</td>
            </tr>
            <tr>
                <th colspan="2">Patrimonio</th>
                <td colspan="2">{{ number_format($balance['patrimonio'], 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
