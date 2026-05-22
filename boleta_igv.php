<?php
$subtotal = "150.00";
//2. Calcular IGV
$igv =$subtotal * 0.18;

//3.Calcular total
$total = $subtotal +$igv;

//4. Mostrar los tres valores con dos decimales
echo "<h3> BOLETA DE VENTA <h3>";
echo "Subtotal: S/" .number_format($subtotal, 2) . "<br>";
echo "IGV: S/" .number_format($igv, 2) . "<br>";
echo "Total: S/" .number_format($total, 2) . "<br>";

//5. Demostrar que PHP conritió el string número automáticamente
echo "<br>";
echo"<h3>Comprobación de tipos</h3>";
echo "Tipo de subtotal original: " . gettype($subtotal) . "<br>";
echo "Tipo despues de operar: " . gettype($igv) . "<br>";

