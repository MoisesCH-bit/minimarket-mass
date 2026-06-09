<?php
declare(strict_types=1);
require_once 'clases/Producto.php';

// Crear el objeto y Asignar Valores
$incaKola     = new Producto('INC500', 'Inca Kola 500ml', 3.50, 48);
$scotchBrite  = new Producto('SCB400', 'Scotch Brite 3uds', 4.50, 30);
$inkaChips    = new Producto('IKC300', 'Inca Chips 135g', 2.50, 10);
$kolaEscocesa = new Producto('KLE200', 'Kola Escocesa 355ml', 4.50, 5);

// Fíjate bien en los paréntesis () al final de cada uno:
echo $incaKola->getNombre();   
echo "<br>";
echo $scotchBrite->getNombre();  
echo "<br>";
echo $inkaChips->getNombre();
echo "<br>";
echo $kolaEscocesa->getNombre();
?>