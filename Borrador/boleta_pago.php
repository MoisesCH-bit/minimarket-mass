<?php
// --- DATOS DEL TRABAJADOR ---
$nombre          = "Juan Carlos Pérez López";
$dni             = "45678901";
$cargo           = "Vendedor";
$area            = "Ventas";
$periodo         = "Mayo 2026";
$dias_trabajados = 30;

// --- REMUNERACIONES ---
$sueldo_basico       = 1500.00;
$asignacion_familiar = 102.50;
$horas_extras        = 3;
$valor_hora_extra    = 12.50;

// --- CÁLCULO DE INGRESOS ---
$total_horas_extras = $horas_extras * $valor_hora_extra;
$total_ingresos     = $sueldo_basico + $asignacion_familiar + $total_horas_extras;

// --- DESCUENTOS DE LEY ---
$porcentaje_onp     = 0.13;
$porcentaje_essalud = 0.09;

$descuento_onp  = $total_ingresos * $porcentaje_onp;
$aporte_essalud = $total_ingresos * $porcentaje_essalud;

$uit           = 5150.00;
$sueldo_anual  = $total_ingresos * 12;
$limite_5ta    = 7 * $uit;
$descuento_5ta = ($sueldo_anual > $limite_5ta)
                 ? ($sueldo_anual - $limite_5ta) * 0.08 / 12
                 : 0.00;

$total_descuentos = $descuento_onp + $descuento_5ta;
$sueldo_neto      = $total_ingresos - $total_descuentos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Boleta de Pago</title>
  <style>
    body {
      font-family: Courier New, monospace;
      display: flex;
      justify-content: center;
      padding: 40px;
      background: #fff;
    }

    .boleta {
      width: 500px;
      border: 1px solid #000;
      padding: 20px;
    }

    h2, p {
      text-align: center;
      margin: 2px 0;
    }

    hr {
      border: none;
      border-top: 1px solid #000;
      margin: 10px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    td {
      padding: 4px 0;
    }

    td:last-child {
      text-align: right;
    }

    .label {
      font-weight: bold;
    }

    .total td {
      border-top: 1px solid #000;
      font-weight: bold;
    }

    .seccion {
      font-weight: bold;
      margin: 10px 0 4px;
      font-size: 13px;
      text-transform: uppercase;
    }
  </style>
</head>
<body>
<div class="boleta">

  <h2>MINIMARKET MASS S.A.C.</h2>
  <p>RUC: 20123456789</p>
  <p>BOLETA DE PAGO — <?= $periodo ?></p>

  <hr>

  <p class="seccion">DATOS DEL TRABAJADOR</p>
  <table>
    <tr><td class="label">Trabajador</td><td><?= $nombre ?></td></tr>
    <tr><td class="label">DNI</td><td><?= $dni ?></td></tr>
    <tr><td class="label">Cargo</td><td><?= $cargo ?></td></tr>
    <tr><td class="label">Área</td><td><?= $area ?></td></tr>
    <tr><td class="label">Días trabajados</td><td><?= $dias_trabajados ?> días</td></tr>
  </table>

  <hr>

  <p class="seccion">INGRESOS</p>
  <table>
    <tr><td>Sueldo básico</td><td>S/ <?= number_format($sueldo_basico, 2) ?></td></tr>
    <tr><td>Asignación familiar</td><td>S/ <?= number_format($asignacion_familiar, 2) ?></td></tr>
    <tr><td>Horas extras (<?= $horas_extras ?> h)</td><td>S/ <?= number_format($total_horas_extras, 2) ?></td></tr>
    <tr class="total"><td>TOTAL INGRESOS</td><td>S/ <?= number_format($total_ingresos, 2) ?></td></tr>
  </table>

  <hr>

  <p class="seccion">DESCUENTOS DE LEY</p>
  <table>
    <tr><td>ONP (13%)</td><td>S/ <?= number_format($descuento_onp, 2) ?></td></tr>
    <tr><td>Imp. 5ta categoría</td><td>S/ <?= number_format($descuento_5ta, 2) ?></td></tr>
    <tr class="total"><td>TOTAL DESCUENTOS</td><td>S/ <?= number_format($total_descuentos, 2) ?></td></tr>
  </table>

  <hr>

  <p class="seccion">APORTE EMPLEADOR (referencial)</p>
  <table>
    <tr><td>EsSalud (9%)</td><td>S/ <?= number_format($aporte_essalud, 2) ?></td></tr>
  </table>

  <hr>

  <table>
    <tr class="total"><td>SUELDO NETO A PAGAR</td><td>S/ <?= number_format($sueldo_neto, 2) ?></td></tr>
  </table>

</div>
</body>
</html>