<?php
// ============================================
// BOLETA DE PAGO - MINIMARKET MASS
// Trabajador: Carlos Eduardo Mamani Quispe
// Periodo: Mayo 2026
// Autor: Josias Fabian Yugra Guevara
// ============================================

// 1. datos del trabajador
$nombre = "Carlos Eduardo Mamani Quispe";
$dni = "74521893";
$cargo = "Jefe de almacen";
$tienda = "Mass Cayma";
$periodo = "Mayo 2026";
$dias_trab = 30;

// 2. ingresos
$sueldo_base = 2850.00;
$asig_familiar = 102.50;
$horas_extras = 12;
$valor_hora_extra = 18.50;

// 3. tasas de descuento y aportes
$tasa_afp = 0.13;
$tasa_renta = 0.08;
$tasa_essalud = 0.09; 

// 4. calculos obligatorios
// Total ganado en horas extra
$pago_horas_extras = $horas_extras * $valor_hora_extra;

// Suma de todos los ingresos usando el operador +
$total_ingresos = $sueldo_base + $asig_familiar + $pago_horas_extras;

// Calculo de porcentajes multiplicando por las tasas
$descuento_afp = $total_ingresos * $tasa_afp;
$descuento_renta = $total_ingresos * $tasa_renta;

// Suma de los descuentos
$total_descuentos = $descuento_afp + $descuento_renta;

// Obtener el sueldo neto
$sueldo_neto = $total_ingresos - $total_descuentos;

// 5. Calculos adicionales
$essalud = $total_ingresos * $tasa_essalud; // reto 1
$costo_empresa = $total_ingresos + $essalud; // reto 2
$fecha_actual = date("d/m/Y"); // reto 3
$sueldo_proporcional = ($sueldo_base / 30) * 22; // reto 4
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de pago</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f9f9f9;
        }
        table { 
            width: 100%; 
            max-width: 800px;
            border-collapse: collapse; 
            margin-bottom: 20px; 
            background-color: white;
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 10px; 
            text-align: left; 
        }
        .cabecera { background-color: #eeeeee; }
        .ingresos { background-color: #e8f5e9; } /* Verde claro para ingresos */
        .descuentos { background-color: #ffebee; } /* Rojo claro para descuentos */
        .totales { font-weight: bold; }
        .info-adicional { background-color: #e3f2fd; } /* Azul claro para info extra */
    </style>
</head>
<body>
    <h1>BOLETA DE PAGO — MINIMARKET MASS</h1>
    <h3>Tienda: <?= $tienda ?> · Periodo: <?= $periodo ?></h3>
    <p><strong>Fecha de emision:</strong> <?= $fecha_actual ?></p> <table>
        <tr class="cabecera">
            <td colspan="2">
                <strong>Trabajador:</strong> <?= $nombre ?><br>
                <strong>DNI:</strong> <?= $dni ?><br>
                <strong>Cargo:</strong> <?= $cargo ?><br>
                <strong>Dias trabajados:</strong> <?= $dias_trab ?>
            </td>
        </tr>
        
        <tr class="ingresos">
            <td colspan="2"><strong>INGRESOS</strong></td>
        </tr>
        <tr>
            <td>Sueldo base</td>
            <td><?php echo "S/ " . number_format($sueldo_base, 2); ?></td>
        </tr>
        <tr>
            <td>Asignacion familiar</td>
            <td><?php echo "S/ " . number_format($asig_familiar, 2); ?></td>
        </tr>
        <tr>
            <td>Horas extras (<?= $horas_extras ?> × S/ <?= number_format($valor_hora_extra, 2) ?>)</td>
            <td><?php echo "S/ " . number_format($pago_horas_extras, 2); ?></td>
        </tr>
        <tr class="ingresos totales">
            <td>Total ingresos</td>
            <td><?php echo "S/ " . number_format($total_ingresos, 2); ?></td>
        </tr>

        <tr class="descuentos">
            <td colspan="2"><strong>DESCUENTOS</strong></td>
        </tr>
        <tr>
            <td>AFP (13%)</td>
            <td><?php echo "S/ " . number_format($descuento_afp, 2); ?></td>
        </tr>
        <tr>
            <td>Impuesto a la Renta (8%)</td>
            <td><?php echo "S/ " . number_format($descuento_renta, 2); ?></td>
        </tr>
        <tr class="descuentos totales">
            <td>Total descuentos</td>
            <td><?php echo "S/ " . number_format($total_descuentos, 2); ?></td>
        </tr>

        <tr>
            <td><h3>SUELDO NETO A PAGAR</h3></td>
            <td><h3><?php echo "S/ " . number_format($sueldo_neto, 2); ?></h3></td>
        </tr>

        <tr class="info-adicional">
            <td colspan="2"><strong>INFORMACION ADICIONAL (RETOS)</strong></td>
        </tr>
        <tr>
            <td>EsSalud (9% - Asumido por empleador)</td>
            <td><?php echo "S/ " . number_format($essalud, 2); ?></td> </tr>
        <tr>
            <td>Costo total para la empresa</td>
            <td><?php echo "S/ " . number_format($costo_empresa, 2); ?></td> </tr>
        <tr>
            <td>Sueldo proporcional (si hubiera trabajado 22 dias)</td>
            <td><?php echo "S/ " . number_format($sueldo_proporcional, 2); ?></td> </tr>
    </table>
</body>
</html>