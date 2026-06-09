<?php
echo $subtotal = "120.50";
echo "<br>";

echo $IGV = 0.18;
echo "<br>";

echo $total = $subtotal + ($subtotal * $IGV);
echo "<br>";

echo "Subtotal formateado: " . number_format($subtotal, 2) . "<br>";
echo "Total con IGV: " . number_format($total, 2) . "<br>";
?>