<?php

$nombre_tienda = "EL RAPIDITO";
$fecha_hoy = date("d/m/Y");
$categorias = ["Abarrotes", "Bebidas", "Limpieza"];
$promo_dia = "¡Llevate 2x1 en todos los  seleccionados solo por hoy!";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida a Mass</title>
</head>
<body>

    <h1>Bienvenido a Mass — <?php echo $nombre_tienda; ?></h1>
    
    <p>Fecha de hoy: <?php echo $fecha_hoy; ?></p>
    
    <h3>Categorías de productos:</h3>
    <ul>
        <li><?php echo $categorias[0]; ?></li>
        <li><?php echo $categorias[1]; ?></li>
        <li><?php echo $categorias[2]; ?></li>
    </ul>
    
    <p><strong>Promoción del día: <?php echo $promo_dia; ?></strong></p>

</body>
</html>