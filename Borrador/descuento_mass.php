<?php
// ============================================
// DESCUENTO MASS - Minimarket Mass
// Archivo: descuento_mass.php
// ============================================

// Monto de compra
$monto_original = 150.00;

// Determinar porcentaje según el monto
if ($monto_original < 30) {
    $porcentaje_descuento = 0;
} elseif ($monto_original <= 99.99) {
    $porcentaje_descuento = 0.05;
} elseif ($monto_original <= 199.99) {
    $porcentaje_descuento = 0.10;
} else {
    $porcentaje_descuento = 0.15;
}

// Calcular montos
$monto_descuento = $monto_original * $porcentaje_descuento;
$monto_final     = $monto_original - $monto_descuento;
$porcentaje_txt  = ($porcentaje_descuento * 100) . "%";

// Mostrar resultados
echo "Monto original:  S/ " . number_format($monto_original, 2) . "<br>";
echo "Descuento:       " . $porcentaje_txt . "<br>";
echo "Monto descuento: S/ " . number_format($monto_descuento, 2) . "<br>";
echo "Monto final:     S/ " . number_format($monto_final, 2) . "<br>";
?>