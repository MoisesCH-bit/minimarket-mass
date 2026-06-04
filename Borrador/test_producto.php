<?php
declare(strict_types=1);
require_once 'clases/Producto.php';

// Objeto 1
$gloria = new Producto('GL500', 'Leche Gloria 500ml', 4.50, 18);
// Objeto 2
$patito = new Producto('P600', 'Detergente Patito', 1.20, 60);
// Objeto 3
$agua = new Producto('AGU625', 'Agua San Luis 625ml', 1.50, 100);


// Mostrar todos
$productos = [$gloria, $patito, $agua];

// Cámbialo por esto 👇
foreach ($productos as $p) {
    echo "Codigo: " . $p->getCodigo() .
         " | Nombre: " . $p->getNombre() .
         " | Precio: S/ " . $p->getPrecio() .
         " | Stock: " . $p->getStock();
    echo "<br>";
}
?>