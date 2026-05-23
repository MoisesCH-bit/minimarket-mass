<?php
// Lista de categorías
$categorias = [
    "frutas y verduras",
    "carne y lacteos",
    "refrescos y congelados"
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Minimarket Mass - Pinto</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; }
        h1 { font-size: 2.5em; margin-bottom: 10px; }
        h2 { font-size: 1.5em; font-weight: normal; }
        h3 { font-size: 1.8em; margin-top: 20px; }
        ul { font-size: 1.4em; font-weight: bold; list-style-type: disc; }
        .promo { font-size: 2em; font-weight: bold; margin-top: 30px; }
    </style>
</head>
<body>

    <h1>Bienvenido a minimarket-mass</h1>

    <h2>hoy es 23 de Mayo del 2026</h2>

    <h3>Categoria Disponibles:</h3>

    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li><?php echo $categoria; ?></li>
        <?php endforeach; ?>
    </ul>

    <div class="promo">
        Promocion del dia 2x1 ¡Compre ya!
    </div>

</body>
</html>