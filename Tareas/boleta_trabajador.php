<?php
// ============================================
// BOLETA DE PAGO - MINIMARKET MASS
// Trabajador: Carlos Eduardo Mamani Quispe
// Periodo: Mayo 2026
// Autor: Moises Colca
// ============================================

// 1. Datos del trabajador
$nombre      = "Carlos Eduardo Mamani Quispe";
$dni         = "74521893";
$cargo       = "Jefe de almacén";
$tienda      = "Mass Cayma";
$periodo     = "Mayo 2026";
$dias_trab   = 30;

// 2. Ingresos
$sueldo_base      = 2850.00;
$asig_familiar    = 102.50;
$horas_extras     = 12;
$valor_hora_extra = 18.50;

// 3. Tasas de descuento
$tasa_afp   = 0.13;
$tasa_renta = 0.08;

// 4. Cálculos obligatorios
$pago_horas_extras = $horas_extras * $valor_hora_extra;
$total_ingresos    = $sueldo_base + $asig_familiar + $pago_horas_extras;
$descuento_afp     = $total_ingresos * $tasa_afp;
$descuento_renta   = $total_ingresos * $tasa_renta;
$total_descuentos  = $descuento_afp + $descuento_renta;
$sueldo_neto       = $total_ingresos - $total_descuentos;

// Reto 1: EsSalud pagado por el empleador (9% del bruto)
$tasa_essalud      = 0.09;
$essalud_empleador = $sueldo_base * $tasa_essalud;

// Reto 2: Costo total para la empresa
$costo_total_empresa = $total_ingresos + $essalud_empleador;

// Reto 3: Fecha actual del sistema
$fecha_actual = date("d/m/Y");

// Reto 4: Sueldo proporcional por 22 días trabajados
$dias_hipoteticos    = 22;
$sueldo_proporcional = ($sueldo_base / $dias_trab) * $dias_hipoteticos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        h3 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid #000; padding: 8px 12px; }
        th { background-color: #ddd; text-align: left; }
        .ingresos th { background-color: #c8e6c9; }
        .descuentos th { background-color: #ffcdd2; }
        .total td { font-weight: bold; }
        .neto td { font-weight: bold; font-size: 1.1em; background-color: #ddd; }
    </style>
</head>
<body>

<h1>BOLETA DE PAGO — MINIMARKET MASS</h1>
<p><strong>Tienda:</strong> <?= $tienda ?> &nbsp;|&nbsp; <strong>Periodo:</strong> <?= $periodo ?> &nbsp;|&nbsp; <strong>Fecha:</strong> <?= $fecha_actual ?></p>

<!-- Datos del trabajador -->
<h3>Datos del trabajador</h3>
<table>
    <tr><td><strong>Nombre</strong></td><td><?= $nombre ?></td></tr>
    <tr><td><strong>DNI</strong></td><td><?= $dni ?></td></tr>
    <tr><td><strong>Cargo</strong></td><td><?= $cargo ?></td></tr>
    <tr><td><strong>Días trabajados</strong></td><td><?= $dias_trab ?></td></tr>
</table>

<!-- Ingresos -->
<h3>Ingresos</h3>
<table class="ingresos">
    <tr><th>Concepto</th><th>Monto</th></tr>
    <tr><td>Sueldo base</td><td>S/ <?= number_format($sueldo_base, 2) ?></td></tr>
    <tr><td>Asignación familiar</td><td>S/ <?= number_format($asig_familiar, 2) ?></td></tr>
    <tr><td>Horas extras (<?= $horas_extras ?> × S/ <?= number_format($valor_hora_extra, 2) ?>)</td><td>S/ <?= number_format($pago_horas_extras, 2) ?></td></tr>
    <tr class="total"><td>Total ingresos</td><td>S/ <?= number_format($total_ingresos, 2) ?></td></tr>
</table>

<!-- Descuentos -->
<h3>Descuentos</h3>
<table class="descuentos">
    <tr><th>Concepto</th><th>Monto</th></tr>
    <tr><td>AFP (13%)</td><td>S/ <?= number_format($descuento_afp, 2) ?></td></tr>
    <tr><td>Impuesto a la Renta 5ta categoría (8%)</td><td>S/ <?= number_format($descuento_renta, 2) ?></td></tr>
    <tr class="total"><td>Total descuentos</td><td>S/ <?= number_format($total_descuentos, 2) ?></td></tr>
</table>

<!-- Sueldo neto -->
<table style="margin-top: 16px;">
    <tr class="neto"><td>SUELDO NETO A PAGAR</td><td>S/ <?= number_format($sueldo_neto, 2) ?></td></tr>
</table>

<!-- Información adicional (retos bonus) -->
<h3>Información adicional</h3>
<table>
    <tr><td>EsSalud pagado por el empleador (9% del bruto)</td><td>S/ <?= number_format($essalud_empleador, 2) ?></td></tr>
    <tr><td>Costo total para la empresa</td><td>S/ <?= number_format($costo_total_empresa, 2) ?></td></tr>
    <tr><td>Sueldo proporcional por <?= $dias_hipoteticos ?> días</td><td>S/ <?= number_format($sueldo_proporcional, 2) ?></td></tr>
</table>

</body>
</html>